<?php

namespace App\Livewire;

use App\Models\Ledger;
use App\Models\Outward;
use Carbon\Carbon;
use Livewire\Component;

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

    public function render()
    {
        return view('livewire.outward-entry');
    }
}
