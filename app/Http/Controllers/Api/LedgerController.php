<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ledger;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
        public function search(Request $request)
    {
        $query = $request->get('query', '');

        $ledgers = Ledger::where('name', 'like', '%' . $query . '%')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($ledgers);
    }

}
