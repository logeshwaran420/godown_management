<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Ledger;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'ledger'); 

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        if ($type === 'ledger') {
            $results = Ledger::where('name', 'LIKE', '%' . $query . '%')->get(['id', 'name']);
        } elseif ($type === 'item') {
            $results = Item::where('name', 'LIKE', '%' . $query . '%')->get(['id', 'name']);
        } elseif ($type === 'category') {
            $results = Category::where('name', 'LIKE', '%' . $query . '%')->get(['id', 'name']);
        } else {
            $results = collect();
        }

        return response()->json($results);
    }
}
