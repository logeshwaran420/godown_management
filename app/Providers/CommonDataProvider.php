<?php

namespace App\Providers;

use App\Models\Ledger;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;



class CommonDataProvider extends ServiceProvider
{
    public function register(): void
    {
        // No need to bind anything if you don't use a separate service class
    }

    public function boot(): void
    {
     
        //   View::composer('*', function ($view) {
        //     $categories = Category::all();
        //     $units = Unit::all();
        //     $ledgers = Ledger::all();
        //     $customers = Ledger::where("type", "customer")->get();
        //     $suppliers = Ledger::where("type", "supplier")->get();
        //     $warehouses = Warehouse::all();

        //     $view->with([
        //         'categories' => $categories,
        //         'units' => $units,
        //         'ledgers' => $ledgers,
        //         'customers' => $customers,
        //         'suppliers' => $suppliers,
        //         'warehouses' => $warehouses,
        //     ]);
        // });
    }
}
