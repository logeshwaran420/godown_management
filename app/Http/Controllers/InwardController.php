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

        return view('inward.create',compact('ledgers','items','categories','units'));
    }


//   public function store(Request $request)
// {

//     $validator = Validator::make($request->all(), [
//         'date' => 'required|date',
//         'ledger_id' => 'required|exists:ledgers,id',
//         'invoice_no' => 'nullable|string',
//         'items' => 'required|array|min:1',
//         'items.*.item_id' => 'required|exists:items,id',
//         'items.*.quantity' => 'required|integer|min:1',
//         'items.*.price' => 'required|numeric|min:0',
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'success' => false,
//             'message' => $validator->errors()->first(),
//         ], 422);
//     }

//     DB::beginTransaction();



//     try {
//         $totalQuantity = 0;
//         $totalAmount = 0;

//        $inward = Inward::create([
//             'date' => $request->date,
//             'ledger_id' => $request->ledger_id,
//             'warehouse_id' => $request->warehouse_id,
//             'invoice_no' => $request->invoice_no,
//         ]);

//         foreach ($request->items as $itemData) {
//             $item = Item::where('id', $itemData['item_id'])->lockForUpdate()->first();

//             if (!$item) {
//                 DB::rollBack();
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Item not found.',
//                 ], 404);
//             }

//             if ($item->current_stock < $itemData['quantity']) {
//                 DB::rollBack();
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Insufficient stock for item: ' . $item->name,
//                 ], 400);
//             }

//              $item->increment('current_stock', $itemData['quantity']);

//             $inventory = Inventory::where('item_id', $itemData['item_id'])
//                                   ->where('warehouse_id', $request->warehouse_id)
//                                   ->lockForUpdate()
//                                   ->first();

//             if ($inventory) {
//                 $inventory->increment('current_stock', $itemData['quantity']);
//             } else {
//                 DB::rollBack();
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Inventory record not found for item: ' . $item->name,
//                 ], 404);
//             }

//             $lineTotal = $itemData['quantity'] * $itemData['price'];

//             InwardDetail::create([
//                 'inward_id' => $inward->id,
//                 'item_id' => $itemData['item_id'],
//                 'quantity' => $itemData['quantity'],
//                 'price' => $itemData['price'],
//                 'total_amount' => $lineTotal,
//             ]);

//             $totalQuantity += $itemData['quantity'];
//             $totalAmount += $lineTotal;
//         }

//          $inward->update([
//             'total_quantity' => $totalQuantity,
//             'total_amount' => $totalAmount,
//         ]);

//         DB::commit();

//         return response()->json([
//             'success' => true,
//             'message' => 'inward entry created successfully!',
//             'inward_id' => $inward->id,
//         ], 200);

//     } catch (\Exception $e) {
//         DB::rollBack();

//         return response()->json([
//             'success' => false,
//             'message' => 'Error saving data: ' . $e->getMessage(),
//         ], 500);
//     }
// }


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

       $warehouseId = session('warehouse_id'); // Single consistent source

$inward = Inward::create([
    'date' => $request->date,
    'ledger_id' => $request->ledger_id,
    'warehouse_id' => $warehouseId,
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
            
            $item->increment('current_stock', $itemData['quantity']);
            $inventory = Inventory::where('item_id', $itemData['item_id'])
                                  ->where('warehouse_id', $request->warehouse_id)
                                  ->lockForUpdate()
                                  ->first();
            if ($inventory) {
                $inventory->increment('current_stock', $itemData['quantity']);
            } else {
               $inventory = Inventory::where('item_id', $itemData['item_id'])
                      ->where('warehouse_id', $warehouseId)
                      ->lockForUpdate()
                      ->first();
            }

            $lineTotal = $itemData['quantity'] * $itemData['price'];

            InwardDetail::create([
                'inward_id' => $inward->id,
                'item_id' => $itemData['item_id'],
                'quantity' => $itemData['quantity'],
                'price' => $itemData['price'],
                'total_amount' => $lineTotal,
            ]);

            $totalQuantity += $itemData['quantity'];
            $totalAmount += $lineTotal;
        }

        $inward->update([
            'total_quantity' => $totalQuantity,
            'total_amount' => $totalAmount,
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Inward entry created successfully!',
            'inward_id' => $inward->id,
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Error saving data: ' . $e->getMessage(),
        ], 500);
    }
}


public function show(inward $inward){

    return view("inward.show",compact("inward"));

}


public function findByBarcode($barcode)
{
    $warehouseId = session('warehouse_id'); 

    $inventory = Inventory::with('item.unit', 'item.category')
        ->where('warehouse_id', $warehouseId)
        ->whereHas('item', function ($q) use ($barcode) {
            $q->where('barcode', $barcode);
        })
        ->first();
    if (!$inventory || !$inventory->item) {
        return response()->json(['message' => 'Item not found in this warehouse'], 404);
    }

    $item = $inventory->item;
    $item->current_stock = $inventory->current_stock; // stock from inventories table

    return response()->json($item);
}


}