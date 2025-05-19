<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Outward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OutwardDetail>
 */
class OutwardDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
      public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 200);
        $item = Item::inRandomOrder()->first();  

        return [
            'outward_id' => Outward::factory(), 
            'item_id' => $item->id, 
            'quantity' => $quantity,
            'price' => $item->price, 
            'total_amount' => $quantity * $item->price,
        ];
    }
}
