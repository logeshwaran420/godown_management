<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\Ledger;
use App\Models\Outward;
use App\Models\OutwardDetail;
use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;
use Validator;

class OutwardController extends Controller
{
    public function index(){


        
          $warehouseId = session('warehouse_id');

    $outwards = Outward::where('warehouse_id', $warehouseId)
                    ->latest()
                    ->paginate(5);

    
return view('outward.index',compact('outwards'));
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

    return view('outward.create', compact('ledgers', 'items'));
}
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'date' => 'required|date',
        'ledger_id' => 'required|exists:ledgers,id',
        'invoice_no' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.item_id' => 'required|exists:items,id',
        'items.*.quantity' => 'required|integer|min:1',
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
            'warehouse_id' => $request->warehouse_id,
            'invoice_no' => $request->invoice_no,
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
                                  ->where('warehouse_id', $request->warehouse_id)
                                  ->lockForUpdate()
                                  ->first();

            if ($inventory) {
                $inventory->decrement('current_stock', $itemData['quantity']);
            } else {
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


}
