<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $guarded = [];

       public function inwards()
    {
        return $this->hasMany(Inward::class);
    }

    public function outwards()
    {
        return $this->hasMany(Outward::class);
    }
}
