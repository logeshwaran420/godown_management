<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
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

    public function destroy(Category $category)
    {
        
   $category->delete();
   return redirect()->route('inventory.categories');
    }

    
}

