<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\Movement;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movement>
 */
class MovementFactory extends Factory
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
            'from_warehouse_id' => Warehouse::inRandomOrder()->first()->id, 
            'to_warehouse_id' => Warehouse::inRandomOrder()->first()->id,           
        ];      
    }

    // public function configure(){
    //     return $this->afterCreating(function (Movement $movement){
           
    //     });
    // }
}
