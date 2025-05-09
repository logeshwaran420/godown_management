<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    public function create(){
        $categories = Category::all();
        $units = Unit::all();        
        return view("inventory.items.create",compact("categories","units"));
    }
    public function store(Request $request){

    $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'category_id' => 'required',
                    'unit_id' => 'required',
                    'hsn_code' => 'nullable|string|max:100',
                    'description' => 'nullable|string',
                   'price' => 'required|numeric|min:0|max:999999.99',
                    'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                ]);


        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('items', 'public');
            $validated['image'] = $image;
        }

        Item::create($validated);
   
        return redirect()->route("inventory.items");
    }

    public function delete(Request $request)
{
   dd($request->all());
    $ids = $request->input('ids', []);

   
    
    Item::whereIn('id', $ids)->delete();

  

    return back();
}

}
