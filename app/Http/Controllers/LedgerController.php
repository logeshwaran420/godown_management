<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    
    
    public function index(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $type = $request->input('type', 'all');
    
    $query = Ledger::query();
    
    if ($type !== 'all') {
        $query->where('type', $type);
    }
    
    $ledgers = $query->paginate($perPage);
    
    return view('ledger.index', compact('ledgers', 'perPage'));
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
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'type' => 'required|in:supplier,customer,both',
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
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'country' => 'nullable|string|max:100',
        'type' => 'required|in:supplier,customer,both',
    ]);

    $ledger->update($validated);

    return redirect()->route('ledgers') 
                     ->with('success', 'Ledger updated successfully.');

    }

    public function destory(ledger $ledger){

   $ledger->delete();
    return redirect()->route('ledgers')->with('success', 'Ledger deleted successfully.');
    }

    public function show(ledger $ledger){
        return view("ledger.show",compact('ledger'));
    }
 public function transaction(Ledger $ledger)
{
    if ($ledger->type === 'customer') {
        $transactions = $ledger->outwards()->latest()->paginate(10);
    } elseif ($ledger->type === 'supplier') {
        $transactions = $ledger->inwards()->latest()->paginate(10); 
        
    } elseif ($ledger->type === 'both') {
        $transactions = $ledger->inwards()->latest()->paginate(10); 
        
    } 
    else {
         $transactions = collect()->paginate(10); 

    }
   
    return view('ledger.transaction', compact('ledger', 'transactions'));


}





}
