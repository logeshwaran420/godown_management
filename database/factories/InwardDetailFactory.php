<?php
namespace Database\Factories;

use App\Models\Inward;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InwardDetail>
 */
class InwardDetailFactory extends Factory
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
            'inward_id' => Inward::factory(), 
            'item_id' => $item->id,
            'quantity' => $quantity,
            'price' => $item->price,
            'total_amount' => $quantity * $item->price,
        ];
    }
}
