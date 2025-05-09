<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Outward;
use Illuminate\Http\Request;

class OutwardController extends Controller
{
    public function items(){


        
          $warehouseId = session('warehouse_id');

    $outwards = Outward::where('warehouse_id', $warehouseId)
                    ->latest()
                    ->paginate(5);

    
return view('outward.items.index',compact('outwards'));
    }

   public function ledgers()
{
    $ledgers = Ledger::where('type', 'customer')->latest()->paginate(5);
    return view('outward.ledgers.index', compact('ledgers'));
}
}
