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

    // Automatically update the outward totals when a detail is saved or updated
    protected static function booted()
    {
        static::saved(function ($detail) {
          $detail->outward->updateTotals();
        });
    }
}
