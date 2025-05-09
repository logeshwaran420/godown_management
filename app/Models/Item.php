<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'unit_id', 'hsn_code', 'description', 'price', 'image', 'current_stock'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

        public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

     public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

   
}
