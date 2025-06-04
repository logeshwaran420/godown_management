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

    $totalQuantity = $this->details->sum('quantity');
    $totalAmount = $this->details->sum(fn($detail) => $detail->quantity * $detail->price);

    if ($this->total_quantity !== $totalQuantity || $this->total_amount !== $totalAmount) {
        $this->total_quantity = $totalQuantity;
        $this->total_amount = $totalAmount;
        $this->save();
    }
}


}
