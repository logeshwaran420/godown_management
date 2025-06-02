<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */public function run()
    {
        $items = [
            // Electronics (category_id=1), units pcs (unit_id=3)
            ['name' => 'Phone', 'category_id' => 1, 'unit_id' => 3, 'price' => 500.00],
            ['name' => 'Laptop', 'category_id' => 1, 'unit_id' => 3, 'price' => 1200.00],
            ['name' => 'TV', 'category_id' => 1, 'unit_id' => 3, 'price' => 800.00],
            ['name' => 'Headphones', 'category_id' => 1, 'unit_id' => 3, 'price' => 150.00],

            // Clothing & Apparel (category_id=2), pcs
            ['name' => 'T-shirt', 'category_id' => 2, 'unit_id' => 3, 'price' => 20.00],
            ['name' => 'Jeans', 'category_id' => 2, 'unit_id' => 3, 'price' => 40.00],
            ['name' => 'Jacket', 'category_id' => 2, 'unit_id' => 3, 'price' => 60.00],
            ['name' => 'Shoes', 'category_id' => 2, 'unit_id' => 3, 'price' => 70.00],

            // Furniture (category_id=3), pcs
            ['name' => 'Table', 'category_id' => 3, 'unit_id' => 3, 'price' => 150.00],
            ['name' => 'Chair', 'category_id' => 3, 'unit_id' => 3, 'price' => 80.00],
            ['name' => 'Bed', 'category_id' => 3, 'unit_id' => 3, 'price' => 300.00],
            ['name' => 'Cabinet', 'category_id' => 3, 'unit_id' => 3, 'price' => 200.00],

            // Food & Beverages (category_id=4), mostly kg or ltr
            ['name' => 'Snacks', 'category_id' => 4, 'unit_id' => 1, 'price' => 5.00],
            ['name' => 'Drinks', 'category_id' => 4, 'unit_id' => 2, 'price' => 3.00],
            ['name' => 'Groceries', 'category_id' => 4, 'unit_id' => 1, 'price' => 10.00],
            ['name' => 'Dairy', 'category_id' => 4, 'unit_id' => 2, 'price' => 4.00],

            // Health & Personal Care (category_id=5), pcs
            ['name' => 'Medicines', 'category_id' => 5, 'unit_id' => 3, 'price' => 25.00],
            ['name' => 'Skincare', 'category_id' => 5, 'unit_id' => 3, 'price' => 15.00],
            ['name' => 'Soaps', 'category_id' => 5, 'unit_id' => 3, 'price' => 3.00],
            ['name' => 'Toothbrushes', 'category_id' => 5, 'unit_id' => 3, 'price' => 2.50],

            // Books & Stationery (category_id=6), pcs
            ['name' => 'Notebooks', 'category_id' => 6, 'unit_id' => 3, 'price' => 7.00],
            ['name' => 'Pens', 'category_id' => 6, 'unit_id' => 3, 'price' => 1.50],
            ['name' => 'Novels', 'category_id' => 6, 'unit_id' => 3, 'price' => 12.00],
            ['name' => 'Office supplies', 'category_id' => 6, 'unit_id' => 3, 'price' => 8.00],

            // Home Appliances (category_id=7), pcs
            ['name' => 'Refrigerator', 'category_id' => 7, 'unit_id' => 3, 'price' => 900.00],
            ['name' => 'Microwave', 'category_id' => 7, 'unit_id' => 3, 'price' => 250.00],
            ['name' => 'Washing Machine', 'category_id' => 7, 'unit_id' => 3, 'price' => 600.00],

            // Tools & Hardware (category_id=8), pcs
            ['name' => 'Screwdriver', 'category_id' => 8, 'unit_id' => 3, 'price' => 10.00],
            ['name' => 'Hammer', 'category_id' => 8, 'unit_id' => 3, 'price' => 15.00],
            ['name' => 'Drill', 'category_id' => 8, 'unit_id' => 3, 'price' => 50.00],
            ['name' => 'Nails', 'category_id' => 8, 'unit_id' => 3, 'price' => 5.00],

            // Toys & Games (category_id=9), pcs
            ['name' => 'Board Games', 'category_id' => 9, 'unit_id' => 3, 'price' => 30.00],
            ['name' => 'Dolls', 'category_id' => 9, 'unit_id' => 3, 'price' => 15.00],
            ['name' => 'Building Blocks', 'category_id' => 9, 'unit_id' => 3, 'price' => 20.00],

            // Automotive Parts (category_id=10), pcs
            ['name' => 'Tyres', 'category_id' => 10, 'unit_id' => 3, 'price' => 100.00],
            ['name' => 'Spark Plugs', 'category_id' => 10, 'unit_id' => 3, 'price' => 25.00],
            ['name' => 'Batteries', 'category_id' => 10, 'unit_id' => 3, 'price' => 80.00],
            ['name' => 'Filters', 'category_id' => 10, 'unit_id' => 3, 'price' => 15.00],

            // Sports & Outdoors (category_id=11), pcs
            ['name' => 'Football', 'category_id' => 11, 'unit_id' => 3, 'price' => 25.00],
            ['name' => 'Tents', 'category_id' => 11, 'unit_id' => 3, 'price' => 150.00],
            ['name' => 'Gym Equipment', 'category_id' => 11, 'unit_id' => 3, 'price' => 300.00],
            ['name' => 'Bicycles', 'category_id' => 11, 'unit_id' => 3, 'price' => 400.00],

            // Jewelry & Accessories (category_id=12), pcs
            ['name' => 'Rings', 'category_id' => 12, 'unit_id' => 3, 'price' => 200.00],
            ['name' => 'Necklaces', 'category_id' => 12, 'unit_id' => 3, 'price' => 350.00],
            ['name' => 'Watches', 'category_id' => 12, 'unit_id' => 3, 'price' => 500.00],
            ['name' => 'Sunglasses', 'category_id' => 12, 'unit_id' => 3, 'price' => 75.00],

            // Beauty Products (category_id=13), pcs
            ['name' => 'Lipsticks', 'category_id' => 13, 'unit_id' => 3, 'price' => 15.00],
            ['name' => 'Creams', 'category_id' => 13, 'unit_id' => 3, 'price' => 25.00],
            ['name' => 'Perfumes', 'category_id' => 13, 'unit_id' => 3, 'price' => 60.00],
            ['name' => 'Foundation', 'category_id' => 13, 'unit_id' => 3, 'price' => 35.00],

            // Pet Supplies (category_id=14), pcs
            ['name' => 'Dog Food', 'category_id' => 14, 'unit_id' => 3, 'price' => 50.00],
            ['name' => 'Pet Toys', 'category_id' => 14, 'unit_id' => 3, 'price' => 15.00],
            ['name' => 'Leashes', 'category_id' => 14, 'unit_id' => 3, 'price' => 20.00],
            ['name' => 'Litter', 'category_id' => 14, 'unit_id' => 3, 'price' => 10.00],
        ];

        foreach ($items as $item) {
            DB::table('items')->insert([
    'name' => $item['name'],
    'barcode' => strtoupper(Str::random(10)),  // generate 10 char uppercase random string
    'category_id' => $item['category_id'],
    'unit_id' => $item['unit_id'],
    'price' => $item['price'],
    'current_stock' => 0,
    'hsn_code' => 'HSN-' . mt_rand(10000, 99999),  // generate HSN code like HSN-12345
    'description' => null,
    'image' => null,
    'created_at' => now(),
    'updated_at' => now(),
            ]);
        }
    }

}
