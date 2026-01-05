<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApPayment extends Model
{
    protected $fillable = [
        'purchase_invoice_id', 'payment_date', 'amount',
        'payment_method', 'reference_number', 'note', 'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    /**
     * Relasi balik ke Invoice.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
    }

    /**
     * Relasi ke User yang memproses pembayaran.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
