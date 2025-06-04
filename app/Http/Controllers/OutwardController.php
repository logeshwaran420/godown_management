<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Ledger;
use App\Models\Outward;
use App\Models\OutwardDetail;
use App\Models\Unit;
use App\Models\Warehouse;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;

class OutwardController extends Controller
{
    public function index()
{
    $warehouseId = session('warehouse_id');
    
    $outwards = Outward::with(['ledger', 'details.item.unit'])
                ->where('warehouse_id', $warehouseId)
                ->latest()
                ->paginate(5);


  
    return view('outward.index', compact('outwards'));
}









public function create()
{
    $warehouseId = session('warehouse_id'); 
    $warehouse = Warehouse::findOrFail($warehouseId);

    $inventories = $warehouse->inventories()
        ->where('current_stock', '>', 0)
        ->with('item.category', 'item.unit')
        ->get();


        $items = $inventories->map(function($inventory) {
        $item = $inventory->item;
        if ($item) {
            $item->current_stock = $inventory->current_stock; 
        }
        return $item;
    })->filter()->values();



    
    $ledgers = Ledger::where('type', 'customer')->get();

    return view('outward.create', 
     compact('ledgers', 'items')
);
}
public function store(Request $request)
{
   $validator = Validator::make($request->all(), [
         'date' => 'required|date',
        'ledger_id' => 'required|exists:ledgers,id',
        'items' => 'required|array|min:1',
        'items.*.item_id' => 'required|exists:items,id',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.price' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    DB::beginTransaction();

    try {
        $totalQuantity = 0;
        $totalAmount = 0;

         $outward = Outward::create([
            'date' => $request->date,
            'ledger_id' => $request->ledger_id,
            'warehouse_id' => session('warehouse_id'),
         
        ]);

        foreach ($request->items as $itemData) {
            $item = Item::where('id', $itemData['item_id'])->lockForUpdate()->first();

            if (!$item) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found.',
                ], 404);
            }

            if ($item->current_stock < $itemData['quantity']) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock for item: ' . $item->name,
                ], 400);
            }

             $item->decrement('current_stock', $itemData['quantity']);

            $inventory = Inventory::where('item_id', $itemData['item_id'])
                                  ->where('warehouse_id', session('warehouse_id'))
                                  ->lockForUpdate()
                                  ->first();

            if ($inventory) {
                $inventory->decrement('current_stock', $itemData['quantity']);
            }else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Inventory record not found for item: ' . $item->name,
                ], 404);
            }

            $lineTotal = $itemData['quantity'] * $itemData['price'];

             OutwardDetail::create([
                'outward_id' => $outward->id,
                'item_id' => $itemData['item_id'],
                'quantity' => $itemData['quantity'],
                'price' => $itemData['price'],
                'total_amount' => $lineTotal,
            ]);

            $totalQuantity += $itemData['quantity'];
            $totalAmount += $lineTotal;
        }

        $outward->update([
            'total_quantity' => $totalQuantity,
            'total_amount' => $totalAmount,
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Outward entry created successfully!',
            'outward_id' => $outward->id,
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Error saving data: ' . $e->getMessage(),
        ], 500);
    }

}
public function show(Outward $outward){
    return view("outward.show",compact("outward"));
}


public function edit(outward $outward){









    
        $ledgers = Ledger::where('type', 'customer')->get();
   

    return view("outward.edit",compact('outward','ledgers'));
}








     public function search($query)
    {
        $ledgers = Ledger::where('type', 'customer')
            ->where('name', 'LIKE', "%{$query}%")
            ->get(['id', 'name']);

        return response()->json($ledgers);
    }

    public function findByBarcode($barcode){
    $warehouseId = session('warehouse_id');

    $inventory = Inventory::with('item.category', 'item.unit')
        ->where('warehouse_id', $warehouseId)
        ->whereHas('item', function ($query) use ($barcode) {
            $query->where('barcode', $barcode);
        })
        ->first();
        
    if (!$inventory || !$inventory->item) {
        return response()->json(['message' => 'Item not found in this warehouse'], 404);
    }

    $item = $inventory->item;
    $item->current_stock = $inventory->current_stock;

    return response()->json($item);
}




public function update(Request $request, Outward $outward)
{
    $warehouseId = session('warehouse_id');

    $validated = $request->validate([
        'date' => 'required|date',
        'ledger_id' => 'required|exists:ledgers,id',
        'item_ids' => 'required|array',
        // 'item_ids.*' => 'exists:items,id',
        'quantities' => 'required|array',
        'quantities.*' => 'numeric|min:1',
        'rates' => 'required|array',
        'rates.*' => 'numeric|min:0',
    ]);

    DB::beginTransaction();

    try {
        $outward->update([
            'date' => $request->date,
            'ledger_id' => $request->ledger_id,
            'total_quantity' => array_sum($request->quantities),
            'total_amount' => collect($request->quantities)->zip($request->rates)->sum(function ($pair) {
                return $pair[0] * $pair[1];
            }),
        ]);

        $oldDetails = $outward->details()->get()->keyBy('item_id');

        $newItems = [];
        foreach ($request->item_ids as $index => $itemId) {
            $newItems[$itemId] = [
                'quantity' => $request->quantities[$index],
                'rate' => $request->rates[$index],
            ];
        }

        $processedItemIds = [];

        foreach ($newItems as $itemId => $data) {
            $quantityNew = $data['quantity'];
            $rateNew = $data['rate'];

            if ($oldDetails->has($itemId)) {
                $oldDetail = $oldDetails[$itemId];
                $quantityOld = $oldDetail->quantity;

                $difference = $quantityNew - $quantityOld;

               $oldDetail->update([
                    'quantity' => $quantityNew,
                    'price' => $rateNew,
                    'total_amount' => $quantityNew * $rateNew,
                ]);

                $item = Item::find($itemId);
                // if ($item && $difference != 0) {
                //     $item->decrement('current_stock', $difference);
                // }

  if ($item) {
    $item->update([
                           'price' => $rateNew, 
                    ]);

                      if ($difference != 0) {
                    $item->decrement('current_stock', $difference);
                }
                }

               
                
                $inventory = Inventory::firstOrCreate(
                    ['item_id' => $itemId, 'warehouse_id' => $warehouseId],
                    ['current_stock' => 0]
                );
                if ($difference != 0) {
                    $inventory->decrement('current_stock', $difference);
                }

                $processedItemIds[] = $itemId;
            } else {
                OutwardDetail::create([
                    'outward_id' => $outward->id,
                    'item_id' => $itemId,
                    'quantity' => $quantityNew,
                    'price' => $rateNew,
                    'total_amount' => $quantityNew * $rateNew,
                ]);

                $item = Item::find($itemId);
                if ($item) {


                    
                    $item->decrement('current_stock', $quantityNew);
                }

                 $inventory = Inventory::firstOrCreate(
                    ['item_id' => $itemId, 'warehouse_id' => $warehouseId],
                    ['current_stock' => 0]
                );
                $inventory->decrement('current_stock', $quantityNew);

                $processedItemIds[] = $itemId;
            }
        }

        $deletedItems = $oldDetails->keys()->diff($processedItemIds);
        foreach ($deletedItems as $deletedItemId) {
            $oldDetail = $oldDetails[$deletedItemId];
            $quantityOld = $oldDetail->quantity;

            $item = Item::find($deletedItemId);
            if ($item) {
                $item->increment('current_stock', $quantityOld);
            }

           $inventory = Inventory::where('item_id', $deletedItemId)
                ->where('warehouse_id', $warehouseId)
                ->first();

            if ($inventory) {
                $inventory->increment('current_stock', $quantityOld);
            }

            $oldDetail->delete();
        }

        DB::commit();

        return redirect()->route('outwards.show', compact('outward'))->with('success', 'Outward updated successfully.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['error' => 'Failed to update outward: ' . $e->getMessage()]);
    }
}


}
