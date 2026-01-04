<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'type',
        'quantity',
        'reference',
        'note',
        'created_by',
    ];

    /* =======================
     |  RELATIONS
     ======================= */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /* =======================
     |  SCOPES
     ======================= */
    public function scopeIn(Builder $query)
    {
        return $query->where('type', 'IN');
    }

    public function scopeOut(Builder $query)
    {
        return $query->where('type', 'OUT');
    }

    /* =======================
     |  STOCK CALCULATION
     ======================= */
    public static function getStock(int $productId, int $warehouseId): float
    {
        $in = static::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->where('type', 'IN')
            ->sum('quantity');

        $out = static::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->where('type', 'OUT')
            ->sum('quantity');

        return $in - $out;
    }
}
