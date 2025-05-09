<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(){
        return view('inventory.categories.create');
    }

    public function store(Request $request){
       
      $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
        category::create($validated);
      

        return redirect()->route('inventory.categories')
        ->with('success', 'Category created successfully.');
    }

    public function update(Request $request, category $category){
   
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
    ]);
 $category->update($validated);

 return redirect()->back();

    }












    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);

        Category::whereIn('id', $ids)->delete();

        return back();
    }

     public function movements(){

        return view('inventory.movements.index');
    }
}

