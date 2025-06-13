<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Movement;
use App\Models\MovementDetail;
use App\Models\Warehouse;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class MovementController extends Controller
{
//     public function index(){

// $movements = Movement::latest('date')
//                       ->paginate(7);
// return view("movement.index",compact('movements'));
//     }
    
    public function index(Request $request)
{
    $perPage = $request->input('per_page', 5); 
    $movements = Movement::latest('date')
                         ->paginate($perPage)
                         ->withQueryString(); 

  
    return view("movement.index", array_merge([
        'movements' => $movements,
        'perPage' => $perPage,
    ]));
}



public function create(){

        $warehouseId = session('warehouse_id'); 
    $from_warehouse = Warehouse::find($warehouseId);


    $warehouses = Warehouse::where('id', '!=', $warehouseId)->get();

      $inventories = $from_warehouse->inventories()
         ->where('current_stock', '>', 0)
        ->with('item.category', 'item.unit')->get();
      $items = $inventories->map(function($inventory) {
        $item = $inventory->item;
       
        if ($item) {
            $item->current_stock = $inventory->current_stock; 
        }
        return $item;
    })->filter()->values(); 
    
    
    return view('movement.create',compact('from_warehouse','warehouses','items'));
        }


// public function store(Request $request)
// {
//     $request->validate([
//         'from_warehouse_id' => 'required|exists:warehouses,id',
//         'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
//         'date' => 'required|date',
//         'items' => 'required|array',
//     ]);
    
//     DB::transaction(function () use ($request) {
     
//         $movement = Movement::create([
//             'from_warehouse_id' => $request->from_warehouse_id,
//             'to_warehouse_id' => $request->to_warehouse_id,
//             'date' => $request->date,
//             'total_quantity' => 0, 
//           ]);

//         $totalQty = 0;

//         foreach ($request->items as $itemId => $data) {
//             $qty = $data['qty'];

//             $fromInventory = Inventory::where('warehouse_id', $request->from_warehouse_id)
//                 ->where('item_id', $itemId)
//                 ->lockForUpdate()
//                 ->first();

//             if (!$fromInventory || $fromInventory->current_stock < $qty) {
//                 throw new \Exception("Not enough stock for item {$data['name']} in source warehouse.");
//             }

//             $fromInventory->decrement('current_stock', $qty);

//             $toInventory = Inventory::firstOrCreate(
//                 [
//                     'warehouse_id' => $request->to_warehouse_id,
//                     'item_id' => $itemId,
//                 ],  
//                 [
//                     'current_stock' => 0,
//                 ]
//             );

//             $toInventory->increment('current_stock', $qty);

//             MovementDetail::create([
//                 'movement_id' => $movement->id,
//                 'item_id' => $itemId,
//                 'barcode' => $data['barcode'],
//                 'name' => $data['name'],
//                 'quantity' => $qty,
//             ]);

//             $totalQty += $qty;
//         }

//      $movement->update(['total_quantity' => $totalQty]);
//     });

//     return redirect()->route('movements')->with('success', 'Movement created successfully.');
// }




public function store(Request $request)
{
    $request->validate([
        'from_warehouse_id' => 'required|exists:warehouses,id',
        'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
        'date' => 'required|date',
        'items' => 'required|array',
    ]);

    DB::transaction(function () use ($request) {

        // Create movement record first with total_quantity=0, will update later
        $movement = Movement::create([
            'from_warehouse_id' => $request->from_warehouse_id,
            'to_warehouse_id' => $request->to_warehouse_id,
            'date' => $request->date,
            'total_quantity' => 0,
        ]);

        $totalQty = 0;

        foreach ($request->items as $itemId => $data) {
            $qty = $data['qty'];

            // Lock inventory record in source warehouse for update (to prevent race conditions)
            $fromInventory = Inventory::where('warehouse_id', $request->from_warehouse_id)
                ->where('item_id', $itemId)
                ->lockForUpdate()
                ->first();

            if (!$fromInventory || $fromInventory->current_stock < $qty) {
                throw new \Exception("Not enough stock for item {$data['name']} in source warehouse.");
            }

            // Decrease stock in source warehouse
            $fromInventory->decrement('current_stock', $qty);

            // Check if inventory record exists for this item in the destination warehouse
            $toInventory = Inventory::where('warehouse_id', $request->to_warehouse_id)
                ->where('item_id', $itemId)
                ->lockForUpdate()
                ->first();

            if ($toInventory) {
                // If exists, increase stock by qty
                $toInventory->increment('current_stock', $qty);
            } else {
                // Else create new inventory record with current_stock = qty
                Inventory::create([
                    'warehouse_id' => $request->to_warehouse_id,
                    'item_id' => $itemId,
                    'current_stock' => $qty,
                ]);
            }

            // Create movement detail
            MovementDetail::create([
                'movement_id' => $movement->id,
                'item_id' => $itemId,
                'barcode' => $data['barcode'],
                'name' => $data['name'],
                'quantity' => $qty,
            ]);

            $totalQty += $qty;
        }

        // Update total quantity in movement record
        $movement->update(['total_quantity' => $totalQty]);
    });

    return redirect()->route('movements')->with('success', 'Movement created successfully.');
}




public function show(movement $movement){

    return view("movement.show",compact('movement'));
}




public function edit(movement $movement){


    
        $warehouseId = session('warehouse_id'); 
    $from_warehouse = Warehouse::find($warehouseId);
    $warehouses = Warehouse::where('id', '!=', $warehouseId)->get();

    
    return view("movement.edit",compact('movement','from_warehouse','warehouses'));
}



public function update(Request $request, Movement $movement)
{
    $request->validate([
        'from_warehouse_id' => 'required|exists:warehouses,id',
        'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
        'date' => 'required|date',
        'items' => 'required|array',
    ]);

    DB::transaction(function () use ($request, $movement) {

        // Step 1: Reverse old stock changes before updating

        foreach ($movement->items as $detail) {
            $itemId = $detail->item_id;
            $qty = $detail->quantity;

            // Restore stock in source warehouse (increase)
            $fromInventory = Inventory::where('warehouse_id', $movement->from_warehouse_id)
                ->where('item_id', $itemId)
                ->lockForUpdate()
                ->first();

            if ($fromInventory) {
                $fromInventory->increment('current_stock', $qty);
            } else {
                Inventory::create([
                    'warehouse_id' => $movement->from_warehouse_id,
                    'item_id' => $itemId,
                    'current_stock' => $qty,
                ]);
            }

            // Reduce stock in destination warehouse (decrease)
            $toInventory = Inventory::where('warehouse_id', $movement->to_warehouse_id)
                ->where('item_id', $itemId)
                ->lockForUpdate()
                ->first();

            if ($toInventory) {
                if ($toInventory->current_stock < $qty) {
                    throw new \Exception("Cannot reverse stock for item ID {$itemId} in destination warehouse, insufficient stock.");
                }
                $toInventory->decrement('current_stock', $qty);
            } else {
                // This should not happen normally but just in case:
                throw new \Exception("Destination inventory record missing for item ID {$itemId}.");
            }
        }

        // Step 2: Update main movement record details
        $movement->update([
            'from_warehouse_id' => $request->from_warehouse_id,
            'to_warehouse_id' => $request->to_warehouse_id,
            'date' => $request->date,
            'total_quantity' => 0, // will update after processing items
        ]);

        // Step 3: Delete old movement details
        $movement->items()->delete();

        // Step 4: Process new items, update stocks and insert details
        $totalQty = 0;

        foreach ($request->items as $itemId => $data) {
            $qty = $data['qty'];

            // Lock inventory record in source warehouse for update
            $fromInventory = Inventory::where('warehouse_id', $request->from_warehouse_id)
                ->where('item_id', $itemId)
                ->lockForUpdate()
                ->first();

            if (!$fromInventory || $fromInventory->current_stock < $qty) {
                throw new \Exception("Not enough stock for item {$data['name']} in source warehouse.");
            }

            $fromInventory->decrement('current_stock', $qty);

            // Lock or create inventory record in destination warehouse
            $toInventory = Inventory::where('warehouse_id', $request->to_warehouse_id)
                ->where('item_id', $itemId)
                ->lockForUpdate()
                ->first();

            if ($toInventory) {
                $toInventory->increment('current_stock', $qty);
            } else {
                Inventory::create([
                    'warehouse_id' => $request->to_warehouse_id,
                    'item_id' => $itemId,
                    'current_stock' => $qty,
                ]);
            }

            MovementDetail::create([
                'movement_id' => $movement->id,
                'item_id' => $itemId,
                'barcode' => $data['barcode'],
                'name' => $data['name'],
                'quantity' => $qty,
            ]);

            $totalQty += $qty;
        }

        // Step 5: Update total quantity on movement record
        $movement->update(['total_quantity' => $totalQty]);
    });

    return redirect()->route('movements.show',compact('movement'))->with('success', 'Movement updated successfully.');
}


}
