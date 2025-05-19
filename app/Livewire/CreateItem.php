<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Inward;
use App\Models\InwardDetail;
use App\Models\Item;
use App\Models\Ledger;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateItem extends Component
{
     use WithFileUploads;
 public $showModal = false;

    public $name, $barcode, $category_id, $unit_id, $price,
           $current_stock, $hsn_code, $description, $image;

    // public $date, $ledger_id, $warehouse_id, $invoice_no, $quantity;

    
    
    public function mount()
    {
        $this->date = now()->toDateString();
        
    // $this->warehouse_id = session('warehouse_id'); 
    }

   
    protected function rules()
    {
        return [
            'name' => 'required|string',
            'barcode' => 'required|string|unique:items,barcode',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'price' => 'required|numeric',
            // 'current_stock' => 'nullable|integer',
            'hsn_code' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            // 'date' => 'required|date',
            // 'ledger_id' => 'required|exists:ledgers,id',
            // 'warehouse_id' => 'required|exists:warehouses,id',
            // 'invoice_no' => 'nullable|string',
            // 'quantity' => 'required|integer|min:1',
        ];
    }

  public function save()
    {

        $this->validate();

      $imagePath = $this->image ? $this->image->store('items', 'public') : null;

        $item = Item::create([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'category_id' => $this->category_id,
            'unit_id' => $this->unit_id,
            'price' => $this->price,
            'current_stock' => null ?? 0,
            'hsn_code' => $this->hsn_code,
            'description' => $this->description,
            'image_path' => $imagePath,
        ]);

    //     $inward = Inward::create([
    //         'date' => $this->date,
    //         'ledger_id' => $this->ledger_id,
    //         'warehouse_id' => $this->warehouse_id,
    //         'invoice_no' => $this->invoice_no,
    //         'total_quantity' => $this->quantity,
    //         'total_amount' => $this->price * $this->quantity,
    //     ]);

    //     InwardDetail::create([
    //         'inward_id' => $inward->id,
    //         'item_id' => $item->id,
    //         'quantity' => $this->quantity,
    //         'price' => $this->price,
    //         'total_amount' => $this->price * $this->quantity,
    //     ]);

    //       Inventory::updateOrCreate(
    //     ['item_id' => $item->id, 'warehouse_id' => $this->warehouse_id],
    //     ['current_stock' => $this->quantity]
    // );


        session()->flash('success', 'Item and Inward entry created successfully.');
        $this->reset();
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.create-item', [
            'categories' => Category::all(),
            'units' => Unit::all(),
            'ledgers' => Ledger::where('type','supplier')->get(),
  ]);
    }
}
