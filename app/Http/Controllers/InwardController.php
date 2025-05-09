<?php

namespace App\Http\Controllers;

use App\Models\Inward;
use App\Models\Ledger;
use Illuminate\Http\Request;

class InwardController extends Controller
{
    public function items(){
          $warehouseId = session('warehouse_id');

    $inwards = Inward::where('warehouse_id', $warehouseId)
                    ->latest()
                    ->paginate(5);
        return view('inward.items.index',compact('inwards'));
    }

    public function ledgers(){
       
        $ledgers = Ledger::where('type','supplier')->latest()->paginate(5);
        return view('inward.ledgers.index',compact('ledgers'));
    }
   
}