<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   // database/factories/InventoryFactory.php
public function definition(): array
{
    return [
        'item_id' =>Item::inRandomOrder()->first()->id,
        'warehouse_id' =>Warehouse::inRandomOrder()->first()->id,
        'current_stock' => $this->faker->numberBetween(10, 100),
    ];
}

}
