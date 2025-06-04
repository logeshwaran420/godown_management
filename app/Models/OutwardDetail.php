<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutwardDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'outward_id',
        'item_id',
        'quantity',
        'price',
        'total_amount',
    ];

    public function outward()
    {
        return $this->belongsTo(Outward::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    protected static function booted()
    {
        // Calculate total_amount before saving
        static::saving(function ($detail) {
            $detail->total_amount = $detail->quantity * $detail->price;
        });

        // Update totals on parent Outward after saving a detail
        static::saved(function ($detail) {
            if ($detail->outward) {
                $detail->outward->updateTotals();
            }
        });

        // Update totals on parent Outward after deleting a detail
        static::deleted(function ($detail) {
            if ($detail->outward) {
                $detail->outward->updateTotals();
            }
        });
    }
}
