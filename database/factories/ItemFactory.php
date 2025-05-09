<?php
namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Models\Movement;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'category_id' => Category::inRandomOrder()->first()->id,
            'unit_id' => Unit::inRandomOrder()->first()->id,
            'price' => $this->faker->randomFloat(2, 10, 500),
            'hsn_code' => $this->faker->unique()->numerify('HSN-#####'),
            'current_stock' => $this->faker->numberBetween(10, 500),
            'description' => $this->faker->sentence(12),
    'image' => $this->faker->imageUrl(640, 480, 'products', true),
        ];
    }
    
    
    public function configure()
    {
        return $this->afterCreating(function (Item $item) {
            
            $quantity = $item->current_stock;
    
            $warehouses = Warehouse::inRandomOrder()->take(2)->get();       
            $fromWarehouse = $warehouses[0];
            $toWarehouse = $warehouses[1];
    
           Inventory::updateOrCreate(
                [
                    
                    'item_id' => $item->id,
                 'warehouse_id' => $fromWarehouse->id,
                'current_stock' => $quantity]
            );
    
            Movement::create([
                'date' => $this->faker->dateTimeThisMonth(),
                'item_id' => $item->id,
                'from_warehouse_id' => $fromWarehouse->id,
                'to_warehouse_id' => $toWarehouse->id,
                'quantity' => $quantity,
            ]);
    
           Inventory::where('item_id', $item->id)
                ->where('warehouse_id', $fromWarehouse->id)
                ->decrement('current_stock', $quantity);
    
            Inventory::updateOrCreate(
                ['item_id' => $item->id, 
                'warehouse_id' => $toWarehouse->id,
                'current_stock' => \DB::raw("current_stock + $quantity")
                ]
            );
        });
    }
    
}
