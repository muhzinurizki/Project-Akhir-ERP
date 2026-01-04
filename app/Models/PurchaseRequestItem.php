<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequestItem extends Model
{
    protected $fillable = [
        'purchase_request_id',
        'product_id',
        'quantity',
        'unit_price',
        'note'
    ];

    /**
     * Relasi ke Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke Header PR (Opsional tapi disarankan)
     */
    public function purchaseRequest(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
}