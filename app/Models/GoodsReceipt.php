<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodsReceipt extends Model
{
    protected $fillable = [
        'gr_number', 
        'purchase_order_id', 
        'user_id', 
        'received_date', 
        'surat_jalan_number', 
        'note'
    ];

    // TAMBAHKAN RELASI INI
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(GoodsReceiptItem::class);
    }

    // Fungsi otomatis generate nomor GR
    public static function generateGrNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now())->count() + 1;
        return 'GR/' . $date . '/' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}