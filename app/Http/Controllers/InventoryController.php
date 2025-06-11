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















// public function graph(Request $request)
// {
  
//     $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
//     $endDate = $request->input('end_date', now()->toDateString());

//     $inwards = Inward::whereBetween('date', [$startDate, $endDate])
//         ->selectRaw('date, SUM(total_quantity) as total_quantity')
//         ->groupBy('date')
//         ->orderBy('date')
//         ->get();

//     $outwards = Outward::whereBetween('date', [$startDate, $endDate])
//         ->selectRaw('date, SUM(total_quantity) as total_quantity')
//         ->groupBy('date')
//         ->orderBy('date')
//         ->get();

//     return response()->json([
//         'inwards' => $inwards,
//         'outwards' => $outwards,
//     ]);
// }
public function graph(Request $request)
{
    $now = now();
    $endDate = $now->toDateTimeString(); // Optional use; not needed in this function

    /** ------------------ Last 24 Hours (4-hour intervals) ------------------ */
    $dayStart = $now->copy()->startOfDay(); // 24 hours ago
    $dayLabels = [];
    $dayIntervals = [];

    for ($i = 0; $i < 6; $i++) {
        $start = $dayStart->copy()->addHours($i * 4);
        $end = $start->copy()->addHours(4);
        $dayLabels[] = $start->format('hA');
        $dayIntervals[] = [$start, $end];
    }

    $monthStart = $now->copy()->subWeeks(4);
    $weekLabels = [];
    $weekIntervals = [];

    for ($i = 0; $i < 4; $i++) {
        $start = $monthStart->copy()->addWeeks($i);
        $end = $start->copy()->addWeek();
        $weekLabels[] = 'Week ' . ($i + 1);
        $weekIntervals[] = [$start, $end];
    }

    $allStart = $now->copy()->subMonths(6);
    $allLabels = [];
    $monthIntervals = [];

    for ($i = 0; $i < 6; $i++) {
        $start = $allStart->copy()->addMonths($i);
        $end = $start->copy()->addMonth();
        $allLabels[] = $start->format('M');
          $monthIntervals[] = [$start, $end];
    }

    $inwardsDay = array_map(function ($interval) {
        return (int) DB::table('inwards')
            ->whereBetween('created_at', $interval)
            ->sum('total_quantity');
    }, $dayIntervals);

    $inwardsWeek = array_map(function ($interval) {
        return (int) DB::table('inwards')
            ->whereBetween('created_at', $interval)
            ->sum('total_quantity');
    }, $weekIntervals);

    $inwardsAll = array_map(function ($interval) {
        return (int) DB::table('inwards')
            ->whereBetween('created_at', $interval)
            ->sum('total_quantity');
    }, $monthIntervals);

    $outwardsDay = array_map(function ($interval) {
        return (int) DB::table('outwards')
            ->whereBetween('created_at', $interval)
            ->sum('total_quantity');
    }, $dayIntervals);

    $outwardsWeek = array_map(function ($interval) {
        return (int) DB::table('outwards')
            ->whereBetween('created_at', $interval)
            ->sum('total_quantity');
    }, $weekIntervals);

    $outwardsAll = array_map(function ($interval) {
        return (int) DB::table('outwards')
            ->whereBetween('created_at', $interval)
            ->sum('total_quantity');
    }, $monthIntervals);

    return response()->json([
        'day_labels'      => $dayLabels,
        'inwards_day'     => $inwardsDay,
        'outwards_day'    => $outwardsDay,

        'week_labels'     => $weekLabels,
        'inwards_week'    => $inwardsWeek,
        'outwards_week'   => $outwardsWeek,

        'month_labels'    => $allLabels,
        'inwards_month'   => $inwardsAll,
        'outwards_month'  => $outwardsAll
    ]);
}


// public function graph(Request $request)
// { $now = now();
   
//     $endDate = $now->toDateTimeString();
//     $dayStart = $now->copy()->subDay();
  


//     $dayLabels = [];
//     $dayIntervals = [];
//     for ($i = 0; $i < 6; $i++) {
        
//         $start = $dayStart->copy()->addHours($i * 4);
       
//         $end = $start->copy()->addHours(4);
       
//         $dayLabels[] = $start->format('hA');
//         $dayIntervals[] = [$start, $end];
//     }

//     $monthStart = $now->copy()->subWeeks(4);
//     $monthLabels = [];
//     $weekIntervals = [];
//     for ($i = 0; $i < 4; $i++) {
//         $start = $monthStart->copy()->addWeeks($i);
//         $end = $start->copy()->addWeek();
//         $monthLabels[] = 'Week ' . ($i + 1);
//         $weekIntervals[] = [$start, $end];
//     }

//     // All view - last 6 months
//     $allStart = $now->copy()->subMonths(6);
//     $allLabels = [];
//     $monthIntervals = [];
//     for ($i = 0; $i < 6; $i++) {
//         $start = $allStart->copy()->addMonths($i);
//         $end = $start->copy()->addMonth();
//         $allLabels[] = $start->format('M');
//         $monthIntervals[] = [$start, $end];
//     }

//     // Query inwards data
//     $inwardsDay = array_map(function ($interval) {
//         return DB::table('inwards')
//             ->whereBetween('created_at', $interval)
//             ->sum('total_quantity');
//     }, $dayIntervals);

//     $inwardsMonth = array_map(function ($interval) {
//         return DB::table('inwards')
//             ->whereBetween('created_at', $interval)
//             ->sum('total_quantity');
//     }, $weekIntervals);

//     $inwardsAll = array_map(function ($interval) {
//         return DB::table('inwards')
//             ->whereBetween('created_at', $interval)
//             ->sum('total_quantity');
//     }, $monthIntervals);

//     // Query outwards data
//     $outwardsDay = array_map(function ($interval) {
//         return DB::table('outwards')
//             ->whereBetween('created_at', $interval)
//             ->sum('total_quantity');
//     }, $dayIntervals);

//     $outwardsMonth = array_map(function ($interval) {
//         return DB::table('outwards')
//             ->whereBetween('created_at', $interval)
//             ->sum('total_quantity');
//     }, $weekIntervals);

//     $outwardsAll = array_map(function ($interval) {
//         return DB::table('outwards')
//             ->whereBetween('created_at', $interval)
//             ->sum('total_quantity');
//     }, $monthIntervals);

//     return response()->json([
//         'day_labels' => $dayLabels,
//         'inwards_day' => $inwardsDay,
//         'outwards_day' => $outwardsDay,
//         'month_labels' => $monthLabels,
//         'inwards_month' => $inwardsMonth,
//         'outwards_month' => $outwardsMonth,
//         'all_labels' => $allLabels,
//         'inwards_all' => $inwardsAll,
//         'outwards_all' => $outwardsAll
//     ]);
// }






}


