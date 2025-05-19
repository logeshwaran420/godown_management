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
   
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'ledger_id' => Ledger::inRandomOrder()->first()->id,
            'warehouse_id' => Warehouse::inRandomOrder()->first()->id,
            'invoice_no' => $this->faker->unique()->numerify('INV-#####'),
        ];
    }
}
