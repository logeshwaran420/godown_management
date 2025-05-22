<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function items(){

       $warehouseId = session('warehouse_id'); 
   
        
    $warehouse = Warehouse::findOrFail($warehouseId);
     $inventories = $warehouse->inventories()->where('current_stock', '>', 0)
        ->paginate(7);
      
        return view("inventory.items.index",compact("inventories"));
    }
    public function categories(){
        $categories = Category::latest()->paginate(7);
        return view('inventory.categories.index',compact('categories'));
    }



    
}
