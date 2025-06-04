<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Inward;
use App\Models\Item;
use App\Models\Movement;
use App\Models\Outward;
use App\Models\Warehouse;
use App\Traits\CommonDataTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use CommonDataTrait;
 public function index()
{
    $warehouseId = session('warehouse_id');
    $warehouse = Warehouse::with(['inventories.item'])->findOrFail($warehouseId);

    $items = Item::with(['inventories' => function($q) use ($warehouseId) {
        $q->where('warehouse_id', $warehouseId);
    }])->get();

    $inventories = $warehouse->inventories()
        ->with('item')
        ->get();

    $movements = Movement::where('from_warehouse_id', $warehouseId)
        ->orWhere('to_warehouse_id', $warehouseId)
        ->get();

    $inwards = Inward::where('warehouse_id', $warehouseId)->get();
    $outwards = Outward::where('warehouse_id', $warehouseId)->get();

    // Calculate additional metrics
    $inventoryValue = $inventories->sum(function($inventory) {
        return $inventory->current_stock * $inventory->item->unit_price;
    });

    $recentActivities = collect()
        ->merge(
            $inwards->map(function($inward) {
                $inward->type = 'inward';
                return $inward;
            })
        )
        ->merge(
            $outwards->map(function($outward) {
                $outward->type = 'outward';
                return $outward;
            })
        )
        ->sortByDesc('created_at')
        ->take(5);

    $lowInventory = $inventories->filter(function($inventory) {
        return $inventory->current_stock < 10;
    });

    $todayInwards = $inwards->filter(function($inward) {
        return Carbon::parse($inward->date)->isToday();
    })->sum('total_quantity');

    $todayOutwards = $outwards->filter(function($outward) {
        return Carbon::parse($outward->date)->isToday();
    })->sum('total_quantity');

     $data = $this->getCommonData();
 
 
     $viewData = array_merge($data, [
        'warehouse' => $warehouse,
        'items' => $items,
        'inventories' => $inventories,
        'movements' => $movements,
        'inwards' => $inwards,
        'outwards' => $outwards,
        'recentActivities' => $recentActivities,
        'lowInventory' => $lowInventory,
        'inventoryValue' => $inventoryValue,
        'todayInwards' => $todayInwards,
        'todayOutwards' => $todayOutwards,
    ]);
  

    return view('welcome', $viewData);
}
}
