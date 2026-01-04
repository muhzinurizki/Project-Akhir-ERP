<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'pr_number',
        'request_date',
        'user_id',
        'note',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    // RELASI PENTING: Untuk mengecek apakah PR sudah jadi PO
    public function purchaseOrder(): HasOne
    {
        return $this->hasOne(PurchaseOrder::class);
    }

    public static function generatePrNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now()->today())->count() + 1;
        return "PR/{$date}/" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function approve() { $this->update(['status' => 'APPROVED']); }
    public function reject() { $this->update(['status' => 'REJECTED']); }
}