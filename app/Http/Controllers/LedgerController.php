<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function index(){

        $ledgers = Ledger::latest()->paginate(7);
        
return view('ledger.index',compact('ledgers'));
    } 

    public function create(){
        return view("ledger.create");
    }

      public function store(Request $request)
    {
     

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:10',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'type' => 'required|in:supplier,customer',
        ]);

        Ledger::create($validated);

       
        return redirect()->route('ledgers')->with('success', 'Ledger created successfully.');
    }
    public function edit(ledger $ledger){

        return view("ledger.edit",compact('ledger'));
    }

    public function update(ledger $ledger , Request $request ){

         $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:500',
        'type' => 'required|in:supplier,customer',
    ]);

    $ledger->update($validated);

    return redirect()->route('ledgers') 
                     ->with('success', 'Ledger updated successfully.');

    }

    public function destory(ledger $ledger){

   $ledger->delete();
    return redirect()->route('ledgers')->with('success', 'Ledger deleted successfully.');
    }
}
