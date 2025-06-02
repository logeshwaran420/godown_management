<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Traits\CommonDataTrait;   

class ItemController extends Controller
{
    use CommonDataTrait;          

    public function create()
    {
        $commonData = $this->getCommonData();

  
        return view('inventory.items.create', $commonData);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|max:255|unique:items,barcode',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'price' => 'required|numeric|min:0',
            'current_stock' => 'nullable|integer|min:0',
            'hsn_code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $validatedData['image'] = $path;
        }

        $item = Item::create($validatedData);

        return redirect()->route('inventory.items.show', $item)
                         ->with('success', 'Item created successfully!');
    }

    public function findByBarcode($barcode)
    {
        $item = Item::with('category','unit')->where('barcode', $barcode)->first();

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        return response()->json($item);
    }

    public function show(Item $item)
    {
        return view('inventory.items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $commonData = $this->getCommonData();

        return view('inventory.items.edit', [
            'item' => $item,
            'categories' => $commonData['categories'],
            'units' => $commonData['units'],
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|max:255|unique:items,barcode,' . $item->id,
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'price' => 'required|numeric|min:0',
            'current_stock' => 'nullable|integer|min:0',
            'hsn_code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && file_exists(public_path('storage/' . $item->image))) {
                unlink(public_path('storage/' . $item->image));
            }
            $path = $request->file('image')->store('items', 'public');
            $validatedData['image'] = $path;
        }

        $item->update($validatedData);

        return redirect()->route('inventory.items.show', $item)
                         ->with('success', 'Item updated successfully!');
    }

    public function destroy(item $item){
        $item->delete();

        return redirect()->route('inventory.items');
    }
}
