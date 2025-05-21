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




}