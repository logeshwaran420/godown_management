<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InwardDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'inward_id', 
        'item_id',
        'quantity',
        'price',
        'total_amount',
    ];

    // Relationships
    public function inward()
    {
        return $this->belongsTo(Inward::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

     protected static function booted()
    {
        static::saving(function ($detail) {
            $detail->total_amount = $detail->quantity * $detail->price;
        });

        static::saved(function ($detail) {
            if ($detail->inward) {
                $detail->inward->updateTotals();
            }
        });

        static::deleted(function ($detail) {
            if ($detail->inward) {
                $detail->inward->updateTotals();
            }
        });
    }
}
