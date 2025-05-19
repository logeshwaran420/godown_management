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
     public function details()
    {
        return $this->hasMany(OutwardDetail::class); // Each outward has many outward details
    }

      public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    

     public function updateTotals()
{
    $this->load('details');

    $this->total_quantity = $this->details->sum('quantity');
    $this->total_amount = $this->details->sum(function ($detail) {
        return $detail->quantity * $detail->price;
    });

    $this->save();
}

}
