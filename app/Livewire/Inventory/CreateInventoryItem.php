<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\InventoryItem;
use App\Models\Category;
use App\Models\Unit;

class CreateInventoryItem extends Component
{
    use WithFileUploads;

    public $name;
    public $barcode;
    public $category_id;
    public $hsn_code;
    public $unit_id;
    public $price;
    public $description;
    public $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'barcode' => 'required|string|max:255|unique:inventory_items,barcode',
        'category_id' => 'required|exists:categories,id',
        'hsn_code' => 'nullable|string|max:50',
        'unit_id' => 'required|exists:units,id',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048', // 2MB max
    ];

    public function mount()
    {
        $this->barcode = 'BAR' . rand(1000, 9999);
    }

    public function save()
    {
        $this->validate();

        $item = new Item();
        $item->name = $this->name;
        $item->barcode = $this->barcode;
        $item->category_id = $this->category_id;
        $item->hsn_code = $this->hsn_code;
        $item->unit_id = $this->unit_id;
        $item->price = $this->price;
        $item->description = $this->description;

        if ($this->image) {
            $item->image_path = $this->image->store('inventory-items', 'public');
        }

        $item->save();

        session()->flash('success', 'Inventory item created successfully!');
        return redirect()->route('inventory.items');
    }

    public function render()
    {
        return view('livewire.inventory.create-inventory-item', [
            'categories' => Category::all(),
            'units' => Unit::all(),
        ])->layout('layouts.app');
    }
}