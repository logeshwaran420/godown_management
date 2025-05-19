<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovementDetail>
 */
class MovementDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
         $quantity = $this->faker->numberBetween(1, 100);
        $item = Item::inRandomOrder()->first();

        return [
            'movement_id' => Movement::factory(), 
            'item_id' => $item->id,
            'quantity' => $quantity,
            'total_amount' => $quantity * $item->price,
        ];
    }
}
