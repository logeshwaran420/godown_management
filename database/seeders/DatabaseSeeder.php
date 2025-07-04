<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Inward;
use App\Models\InwardDetail;
use App\Models\Item;
use App\Models\Ledger;
use App\Models\Movement;
use App\Models\Outward;
use App\Models\OutwardDetail;  // Make sure this is imported correctly
use App\Models\Unit;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed users and units
        User::insert([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => bcrypt("password123"),
        ]);

        Unit::insert([
            ['name' => 'Kilogram', 'abbreviation' => 'kg'],
            ['name' => 'Liter', 'abbreviation' => 'ltr'],
            ['name' => 'Piece', 'abbreviation' => 'pcs'],
        ]);
        
        Warehouse::factory(3)->create();
         Ledger::factory(15)->create();
    }
}
