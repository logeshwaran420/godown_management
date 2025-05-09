<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outward extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

      public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
