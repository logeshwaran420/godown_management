<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function create(){
        $categories = Category::all();
        $units = Unit::all();        
        return view("inventory.stocks.create",compact("categories","units"));
    }
    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id ' => 'required',
            'unit_id' => 'required',
            'hsn_code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        dd($validated);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('stocks', 'public');
            $validated['image'] = $image;
        }

        Item::create($validated);
        return redirect()->route("inventory.stocks");
    }
}
