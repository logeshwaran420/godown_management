<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inward extends Model
{
    use HasFactory;
    protected $guarded = [];

       public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }

      public function details()
    {
        return $this->hasMany(InwardDetail::class); 
    }

       public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function updateTotals()
{
    $details = $this->details()->get();

    $this->total_quantity = $details->sum('quantity');
    $this->total_amount = $details->sum(function ($detail) {
        return $detail->quantity * $detail->price;
    });

    $this->save();
}
}
