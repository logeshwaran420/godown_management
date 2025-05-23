<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Inward;
use App\Models\Item;
use App\Models\Movement;
use App\Models\Outward;
use App\Models\Warehouse;
use App\Traits\CommonDataTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use CommonDataTrait;
    public function index(){
        
        $warehouseId = session('warehouse_id');
        $warehouse = Warehouse::findOrFail($warehouseId);


        $data = $this->getCommonData();
        $items = Item::all();
        $movements = Movement::where('from_warehouse_id',$warehouseId)->get();
        $inwards = Inward::where('warehouse_id',$warehouseId)->get();
        $outwards = Outward::where('warehouse_id',$warehouseId)->get();
        $inventories = Inventory::where('warehouse_id',$warehouseId)->get();
       

    return view('welcome',compact('items','movements','inwards','outwards','warehouse','inventories'),$data);
    }
}
