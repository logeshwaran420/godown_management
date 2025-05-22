<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Inward;
use App\Models\InwardDetail;
use App\Models\Item;
use App\Models\Ledger;
use App\Models\Unit;
use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;
use Validator;

class InwardController extends Controller
{
    public function index(){
          $warehouseId = session('warehouse_id');

    $inwards = Inward::where('warehouse_id', $warehouseId)
                    ->latest()
                    ->paginate(5);
        return view('inward.index',compact('inwards'));
    }

    public function create(){

        $categories = Category::all();
        $units = Unit::all();
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


    $ledgers = Ledger::where('type', 'supplier')->get();

        return view('inward.create'
        ,compact('ledgers','items','categories','units')
    );
    }








public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'ledger_id' => 'required|exists:ledgers,id',
        'items' => 'required|array|min:1',
        'items.*.item_id' => 'required|exists:items,id',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.price' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {
        $inward = Inward::create([
            'date' => $request->date,
            'ledger_id' => $request->ledger_id,
            'warehouse_id' => session('warehouse_id'),
        ]);

        foreach ($request->items as $item) {
            InwardDetail::create([
                'inward_id' => $inward->id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $inventory = Inventory::where('item_id', $item['item_id'])
                ->where('warehouse_id', $inward->warehouse_id)
                ->first();

            if ($inventory) {
                $inventory->current_stock += $item['quantity'];
                $inventory->save();
            } else {
                Inventory::create([
                    'item_id' => $item['item_id'],
                    'warehouse_id' => $inward->warehouse_id,
                    'current_stock' => $item['quantity'],
                ]);
            }

            $itemModel = Item::find($item['item_id']);
            $itemModel->current_stock += $item['quantity'];
            $itemModel->save();
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Inward entry and stock updated successfully.',
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
        ], 500);
    }
}



public function show(inward $inward){

    return view("inward.show",compact("inward"));

}

public function edit(inward $inward){

    $ledgers = Ledger::where('type', 'supplier')->get();
    $categories = category::all();
    $units = unit::all();
        return view('inward.edit',compact('inward','ledgers','categories','units'));
}


  public function findByBarcode($barcode)
    {
        $item = Item::with('category','unit')->where('barcode', $barcode)->first();
        
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        return response()->json($item);
    }



    public function search($ledger)
{
    return Ledger::where('type', 'supplier')
                 ->where('name', 'LIKE', "%{$ledger}%")
                 ->get(['id', 'name']);
}


public function update(Request $request, Inward $inward)
{
    $warehouseId = session('warehouse_id');

    $validated = $request->validate([
        'date' => 'required|date',
        'ledger_id' => 'required|exists:ledgers,id',
        'item_ids' => 'required|array',
        'quantities' => 'required|array',
        'quantities.*' => 'numeric|min:1',
        'rates' => 'required|array',
        'rates.*' => 'numeric|min:0',
        'category_ids' => 'required|array',
        'category_ids.*' => 'exists:categories,id',
        'unit_ids' => 'required|array',
        'unit_ids.*' => 'exists:units,id',
        'item_names' => 'required|array',
        'item_names.*' => 'string|max:255',
        'hsn_codes' => 'required|array',
        'hsn_codes.*' => 'string|max:255',
    ]);

    DB::beginTransaction();

    try {
        $inward->update([
            'date' => $request->date,
            'ledger_id' => $request->ledger_id,
            'total_quantity' => array_sum($request->quantities),
            'total_amount' => collect($request->quantities)->zip($request->rates)->sum(function ($pair) {
                return $pair[0] * $pair[1];
            }),
        ]);

        $oldDetails = $inward->details()->get()->keyBy('item_id');

        $newItems = [];
        foreach ($request->item_ids as $index => $itemId) {
            $newItems[$itemId] = [
                'quantity' => $request->quantities[$index],
                'rate' => $request->rates[$index],
                'category_id' => $request->category_ids[$index],
                'unit_id' => $request->unit_ids[$index],
                'name' => $request->item_names[$index],
                'hsn_code' => $request->hsn_codes[$index],
            ];
        }

        $processedItemIds = [];

        foreach ($newItems as $itemId => $data) {
            $quantityNew = $data['quantity'];
            $rateNew = $data['rate'];
            $categoryId = $data['category_id'];
            $unitId = $data['unit_id'];
            $itemName = $data['name'];
            $hsnCode = $data['hsn_code'];

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
                if ($item) {
                    $item->update([
                        'category_id' => $categoryId,
                        'unit_id' => $unitId,
                        'name' => $itemName,
                        'hsn_code' => $hsnCode,
                        'price' => $rateNew, // optional if you want to update
                    ]);

                    if ($difference != 0) {
                        $item->increment('current_stock', $difference);
                    }
                }

                $inventory = Inventory::firstOrCreate(
                    ['item_id' => $itemId, 'warehouse_id' => $warehouseId],
                    ['current_stock' => 0]
                );
                if ($difference != 0) {
                    $inventory->increment('current_stock', $difference);
                }

                $processedItemIds[] = $itemId;
            } else {
                // New item detail
                InwardDetail::create([
                    'inward_id' => $inward->id,
                    'item_id' => $itemId,
                    'quantity' => $quantityNew,
                    'price' => $rateNew,
                    'total_amount' => $quantityNew * $rateNew,
                ]);

                $item = Item::find($itemId);
                if ($item) {
                    $item->update([
                        'category_id' => $categoryId,
                        'unit_id' => $unitId,
                        'name' => $itemName,
                        'hsn_code' => $hsnCode,
                        'price' => $rateNew,
                    ]);

                    $item->increment('current_stock', $quantityNew);
                }

                $inventory = Inventory::firstOrCreate(
                    ['item_id' => $itemId, 'warehouse_id' => $warehouseId],
                    ['current_stock' => 0]
                );
                $inventory->increment('current_stock', $quantityNew);

                $processedItemIds[] = $itemId;
            }
        }

        $deletedItems = $oldDetails->keys()->diff($processedItemIds);
        foreach ($deletedItems as $deletedItemId) {
            $oldDetail = $oldDetails[$deletedItemId];
            $quantityOld = $oldDetail->quantity;

            $item = Item::find($deletedItemId);
            if ($item) {
                $item->decrement('current_stock', $quantityOld);
            }

            $inventory = Inventory::where('item_id', $deletedItemId)
                ->where('warehouse_id', $warehouseId)
                ->first();

            if ($inventory) {
                $inventory->decrement('current_stock', $quantityOld);
            }

            $oldDetail->delete();
        }

        DB::commit();

        return redirect()->route('inwards.show', compact('inward'))->with('success', 'Inward updated successfully.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['error' => 'Failed to update inward: ' . $e->getMessage()]);
    }
}




}