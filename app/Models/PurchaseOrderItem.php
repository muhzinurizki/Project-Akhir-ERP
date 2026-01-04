<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    // Tanpa ini, $po->items()->create() akan diabaikan oleh Laravel
    protected $fillable = [
        'purchase_order_id', 
        'product_id', 
        'qty', 
        'unit_price', 
        'total_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}