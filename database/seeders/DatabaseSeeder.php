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
        Category::factory(10)->create();
        Ledger::factory(10)->create();
        Item::factory(30)->create();
      Outward::factory(5)
            ->has(
                OutwardDetail::factory()->count(3), 
                'details')
            ->create();
            
                 Inward::factory(5)
            ->has(
                InwardDetail::factory()->count(3), 
                'details'
            )
            ->create();
    }
}
