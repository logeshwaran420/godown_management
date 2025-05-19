<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementDetail extends Model
{
     protected $fillable = ['movement_id', 'item_id', 'quantity'];
        public function movement()
{
    return $this->belongsTo(Movement::class);
}

public function item()
{
    return $this->belongsTo(Item::class);
}
}
