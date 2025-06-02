<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Traits\CommonDataTrait; 

class InventoryController extends Controller
{
    use CommonDataTrait; 
    public function items()
{
     $warehouseId = session('warehouse_id');
   

    $warehouse = Warehouse::findOrFail($warehouseId);

    $inventories = $warehouse->inventories()
        ->with(['item' => function($query) {
            $query->with(['unit', 'category']); 
        }])
        ->latest()
        ->paginate(6);

    $totalItems = $warehouse->inventories()->sum('current_stock');
    

$totalValue = $warehouse->inventories()
    ->with('item') 
    ->get() 
    ->sum(function($inventory) {
        return $inventory->current_stock * $inventory->item->price;
    });

    
$lowStockItems = $warehouse->inventories()
    ->where('current_stock', '<=', 10) 
    ->count();


    $commonData = $this->getCommonData();

    return view("inventory.items.index", array_merge([
        'inventories' => $inventories,
        'warehouse' => $warehouse,
        'totalItems' => $totalItems,
        'totalValue' => $totalValue,
         'lowStockItems' => $lowStockItems,
    ], $commonData));
}
    public function categories()
    {
      $categories = Category::latest()->paginate(7);
      return view('inventory.categories.index',compact('categories'));
    }
}

