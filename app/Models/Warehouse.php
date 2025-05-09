<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $guarded = [];

   public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

       public function movementsFrom()
    {
        return $this->hasMany(Movement::class, 'from_warehouse_id');
    }

    public function movementsTo()
    {
        return $this->hasMany(Movement::class, 'to_warehouse_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
