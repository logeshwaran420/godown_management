<?php

namespace App\Http\Controllers;

use App\Models\Inward;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function receive()
    {
        $inwards = Inward::latest()->paginate(5);
        return view('purchase.receives.index',compact('inwards'));
    }

}
