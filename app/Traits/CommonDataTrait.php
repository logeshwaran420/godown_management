<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\Unit;
use App\Models\Ledger;
use App\Models\Warehouse;

trait CommonDataTrait
{
    public function getCommonData()
    {
        return [
            'categories' => Category::all(),
            'units' => Unit::all(),
            'ledgers' => Ledger::all(),
            'customers' => Ledger::where('type', 'customer')->get(),
            'suppliers' => Ledger::where('type', 'supplier')->get(),
            'warehouses' => Warehouse::all(),
        ];
    }
}