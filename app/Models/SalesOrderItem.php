<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    protected $fillable = [
        'sales_order_id',
        'product_id',
        'quantity',
        'shipped_quantity'
    ];

    /**
     * Relasi balik ke Header SO
     */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    /**
     * Relasi ke Produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor: Menghitung sisa barang yang belum dikirim
     */
    public function getRemainingQuantityAttribute()
    {
        return $this->quantity - $this->shipped_quantity;
    }
}