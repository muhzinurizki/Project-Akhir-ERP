<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsPayable extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'purchase_order_id',
        'goods_receipt_id',
        'ap_number',
        'amount',
        'paid_amount',
        'status',
        'due_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    /* ================= Relations ================= */

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceipt::class);
    }

    /* ================= Helper ================= */

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }
}
