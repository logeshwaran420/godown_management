<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Devices and gadgets including phones, laptops, TVs, and headphones, designed to enhance communication, entertainment, and productivity.',
            ],
            [
                'name' => 'Clothing & Apparel',
                'description' => 'A variety of wearable items such as t-shirts, jeans, jackets, and shoes, offering style and comfort for everyday life.',
            ],
            [
                'name' => 'Furniture',
                'description' => 'Essential home and office furnishings including tables, chairs, beds, and cabinets, combining functionality with design.',
            ],
            [
                'name' => 'Food & Beverages',
                'description' => 'A wide range of consumables like snacks, drinks, groceries, and dairy products, catering to everyday dietary needs.',
            ],
            [
                'name' => 'Health & Personal Care',
                'description' => 'Products focused on wellbeing and hygiene such as medicines, skincare, soaps, and toothbrushes for maintaining health.',
            ],
            [
                'name' => 'Books & Stationery',
                'description' => 'Materials for reading and writing, including notebooks, pens, novels, and office supplies, supporting education and creativity.',
            ],
            [
                'name' => 'Home Appliances',
                'description' => 'Essential household machines like refrigerators, microwaves, and washing machines, designed to simplify daily chores.',
            ],
            [
                'name' => 'Tools & Hardware',
                'description' => 'Handy instruments such as screwdrivers, hammers, drills, and nails used for construction, repairs, and DIY projects.',
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Fun and educational items like board games, dolls, and building blocks to engage children and promote learning.',
            ],
            [
                'name' => 'Automotive Parts',
                'description' => 'Components and accessories such as tyres, spark plugs, batteries, and filters necessary for vehicle maintenance and repair.',
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Equipment including footballs, tents, gym gear, and bicycles to support active lifestyles and outdoor adventures.',
            ],
            [
                'name' => 'Jewelry & Accessories',
                'description' => 'Fashion items like rings, necklaces, watches, and sunglasses that enhance personal style and expression.',
            ],
            [
                'name' => 'Beauty Products',
                'description' => 'Cosmetics and skincare essentials such as lipsticks, creams, perfumes, and foundation to help people look and feel their best.',
            ],
            [
                'name' => 'Pet Supplies',
                'description' => 'Items for pet care including dog food, toys, leashes, and litter to ensure the health and happiness of pets.',
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
