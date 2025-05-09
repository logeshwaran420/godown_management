<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Ledger;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outward>
 */
class OutwardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'ledger_id' => Ledger::inRandomOrder()->first()->id, 
            'item_id' => Item::inRandomOrder()->first()->id, 
            'warehouse_id' => Warehouse::inRandomOrder()->first()->id, 
            'quantity' => $this->faker->numberBetween(1, 200),
            'price' => $this->faker->randomFloat(2, 10, 500), 
            'total_amount' => function (array $total) {
                return $total['price'] * $total['quantity'];
            },
            'invoice_no' => $this->faker->optional()->word, 
        ];
    }
}
