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

    $inventories = item::latest()->paginate(10);




    $commonData = $this->getCommonData();

    return view("inventory.items.index", array_merge([
        'inventories' => $inventories,
       
    ], $commonData));



}
    public function categories()
    {
      $categories = Category::latest()->paginate(7);
      return view('inventory.categories.index',compact('categories'));
    }
}

