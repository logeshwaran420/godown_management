<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  public function index(Request $request)
{
    $query = $request->input('q');

    $ledgers = Ledger::where('name', 'LIKE', '%' . $query . '%')
        ->limit(10)
        ->get();
        

    return response()->json($ledgers);
}



}
