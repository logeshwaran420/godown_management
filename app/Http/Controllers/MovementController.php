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
    public function index(){

$movements = Movement::latest('date')
                      ->paginate(7);
return view("movement.index",compact('movements'));
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


public function store(Request $request)
{
    $request->validate([
        'from_warehouse_id' => 'required|exists:warehouses,id',
        'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
        'date' => 'required|date',
        'items' => 'required|array',
    ]);

    DB::transaction(function () use ($request) {
     
        $movement = Movement::create([
            'from_warehouse_id' => $request->from_warehouse_id,
            'to_warehouse_id' => $request->to_warehouse_id,
            'date' => $request->date,
            'total_quantity' => 0, 
          ]);

        $totalQty = 0;

        foreach ($request->items as $itemId => $data) {
            $qty = $data['quantity'];

            $fromInventory = Inventory::where('warehouse_id', $request->from_warehouse_id)
                ->where('item_id', $itemId)
                ->lockForUpdate()
                ->first();

            if (!$fromInventory || $fromInventory->current_stock < $qty) {
                throw new \Exception("Not enough stock for item {$data['name']} in source warehouse.");
            }

            $fromInventory->decrement('current_stock', $qty);

            $toInventory = Inventory::firstOrCreate(
                [
                    'warehouse_id' => $request->to_warehouse_id,
                    'item_id' => $itemId,
                ],
                [
                    'current_stock' => 0,
                ]
            );

            $toInventory->increment('current_stock', $qty);

            MovementDetail::create([
                'movement_id' => $movement->id,
                'item_id' => $itemId,
                'barcode' => $data['barcode'],
                'name' => $data['name'],
                'quantity' => $qty,
            ]);

            $totalQty += $qty;
        }

     $movement->update(['total_quantity' => $totalQty]);
    });

    return redirect()->route('movements')->with('success', 'Movement created successfully.');
}

public function show(movement $movement){

    return view("movement.show",compact('movement'));
}

}
