<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Inward;
use App\Models\Item;
use App\Models\Outward;
use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;
use App\Traits\CommonDataTrait; 

class InventoryController extends Controller
{
    use CommonDataTrait; 
 public function items(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $inventories = Item::latest()->paginate($perPage)->withQueryString(); 

    
    $commonData = $this->getCommonData();

    return view("inventory.items.index", array_merge([
        'inventories' => $inventories,
        'perPage' => $perPage,
    ], $commonData));
}

public function categories()
    {
      $categories = Category::latest()->paginate(7);
      
      return view('inventory.categories.index',compact('categories'));
    }












public function graph(Request $request)
{
    $now = now();

    $dayStart = $now->copy()->startOfDay()->addHours(8);
    $dayLabels = [];
    $dayIntervals = [];

    for ($i = 0; $i < 6; $i++) {
        $start = $dayStart->copy()->addHours($i * 2);
        $end = $start->copy()->addHours(4);
        $dayLabels[] = $start->format('hA');
        $dayIntervals[] = [$start, $end];
    }

  
    $monthStart = $now->copy()->startOfMonth(); 
$weekLabels = [];
$weekIntervals = [];



    for ($i = 0; $i < 4; $i++) {
        $start = $monthStart->copy()->addWeeks($i);
        $end = $start->copy()->addWeek();
        $weekLabels[] = 'Week ' . ($i + 1);
        $weekIntervals[] = [$start, $end];
    }

    $monthStart = $now->copy()->startOfMonth();
    $allLabels = [];
    $monthIntervals = [];

    for ($i = 0; $i < 6; $i++) {
        $start = $monthStart->copy()->addMonths($i);
        $end = $start->copy()->addMonth();
        $allLabels[] = $start->format('M');
        $monthIntervals[] = [$start, $end];
    }

    $yearStart = $now->copy()->startOfYear(); 
    $allYearLabels = [];
    $yearIntervals = [];


    for ($i = 0; $i < 6; $i++) {
        $start = $yearStart->copy()->addMonths($i);
        $end = $start->copy()->addMonth();
        $allYearLabels[] = $start->format('M');
        $yearIntervals[] = [$start, $end];
    }

    $inwardsDay = array_map(fn($interval) => (int) DB::table('inwards')->whereBetween('created_at', $interval)->sum('total_quantity'), $dayIntervals);
    $outwardsDay = array_map(fn($interval) => (int) DB::table('outwards')->whereBetween('created_at', $interval)->sum('total_quantity'), $dayIntervals);

    $inwardsWeek = array_map(fn($interval) => (int) DB::table('inwards')->whereBetween('created_at', $interval)->sum('total_quantity'), $weekIntervals);
    $outwardsWeek = array_map(fn($interval) => (int) DB::table('outwards')->whereBetween('created_at', $interval)->sum('total_quantity'), $weekIntervals);

    $inwardsMonth = array_map(fn($interval) => (int) DB::table('inwards')->whereBetween('created_at', $interval)->sum('total_quantity'), $monthIntervals);
    $outwardsMonth = array_map(fn($interval) => (int) DB::table('outwards')->whereBetween('created_at', $interval)->sum('total_quantity'), $monthIntervals);

    $inwardsAll = array_map(fn($interval) => (int) DB::table('inwards')->whereBetween('created_at', $interval)->sum('total_quantity'), $yearIntervals);
    $outwardsAll = array_map(fn($interval) => (int) DB::table('outwards')->whereBetween('created_at', $interval)->sum('total_quantity'), $yearIntervals);

    return response()->json([
        'day_labels'      => $dayLabels,
        'inwards_day'     => $inwardsDay,
        'outwards_day'    => $outwardsDay,

        'weekLabels'      => $weekLabels,
        'inwardsWeek'     => $inwardsWeek,
        'outwardsWeek'    => $outwardsWeek,

        'month_labels'    => $allLabels,      
        'inwards_month'   => $inwardsMonth,
        'outwards_month'  => $outwardsMonth,

        'all_labels'      => $allYearLabels,   
        'inwards_all'     => $inwardsAll,
        'outwards_all'    => $outwardsAll,
    ]);
}


}


