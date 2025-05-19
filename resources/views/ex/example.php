<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ledger;
use Carbon\Carbon;

class OutwardEntry extends Component
{
    public $date;
    public $name;
    public $current_stock;
    public $unit_id;
    public $price;
    public $ledgers = [];

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d');
        $this->ledgers = Ledger::all();
    }

    public function updated($field)
    {
        if (in_array($field, ['current_stock', 'unit_id'])) {
            $this->calculatePrice();
        }
    }

    public function calculatePrice()
    {
        if (is_numeric($this->current_stock) && is_numeric($this->unit_id)) {
            $this->price = $this->current_stock * $this->unit_id;
        } else {
            $this->price = '';
        }
    }

    public function submit()
    {
        $this->validate([
            'date' => 'required|date',
            'name' => 'required|exists:ledgers,id',
            'current_stock' => 'required|numeric|min:0',
            'unit_id' => 'required|numeric|min:1',
        ]);

        // Store logic here
        // Outward::create([...])

        session()->flash('success', 'Outward entry created successfully.');
        $this->reset(['current_stock', 'unit_id', 'price', 'name']);
    }

    public function render()
    {
        return view('livewire.outward-entry');
    }
}

?>  <div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center py-3 px-3">
        <h1 class="text-xl font-semibold">Outward Entry</h1>
    </div>

    <form wire:submit.prevent="submit" class="flex justify-between max-w-5xl mx-auto gap-10">
        <div class="flex-1 space-y-5">

            <div class="flex items-start">
                <label for="date" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Date</label>
                <div class="w-2/3">
                    <input type="date" id="date" wire:model="date"
                           class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-start">
                <label for="name" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Name</label>
                <div class="w-2/3">
                    <select id="name" wire:model="name"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Select Ledger</option>
                        @foreach($ledgers as $ledger)
                            <option value="{{ $ledger->id }}">{{ $ledger->name }}</option>
                        @endforeach
                    </select>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-start">
                <label for="current_stock" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Item</label>
                <div class="w-2/3 flex gap-4">
                    <input wire:model="current_stock" id="current_stock" placeholder="HSN code"
                           class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('current_stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

                    <div class="w-2/3">
                        <input wire:model="unit_id" type="number" placeholder="Quantity"
                               class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('unit_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-start">
                <label for="price" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Total Price</label>
                <div class="w-2/3">
                    <input type="text" id="price" wire:model="price" readonly
                           class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Total Price">
                    @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center">
                <div class="w-1/3"></div>
                <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </div>

        </div>
    </form>

    @if (session()->has('success'))
        <div class="mt-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif
</div>





<div>