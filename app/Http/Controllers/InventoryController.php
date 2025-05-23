<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Traits\CommonDataTrait;   // <-- Import the trait

class InventoryController extends Controller
{
    use CommonDataTrait;  // <-- Use the trait

    public function items()
    {
        $warehouseId = session('warehouse_id'); 
        $warehouse = Warehouse::findOrFail($warehouseId);
        $inventories = $warehouse->inventories()->latest()->paginate(7);

        $commonData = $this->getCommonData();

        // Pass inventories + common data to view
        return view("inventory.items.index", array_merge(['inventories' => $inventories], $commonData));
    }

    public function categories()
    {
        $categories = Category::latest();

    
        
        return view('inventory.categories.index', array_merge(['categories' => $categories]));
    }
}
