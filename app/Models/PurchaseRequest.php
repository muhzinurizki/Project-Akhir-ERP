<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'pr_number',
        'request_date',
        'user_id',
        'note',
        'status'
    ];

    // Relasi ke User (Pembuat PR)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Item Detail
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    // Logika Generate Nomor PR Otomatis: PR/20260104/0001
    public static function generatePrNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now()->today())->count() + 1;
        $formattedCount = str_pad($count, 4, '0', STR_PAD_LEFT);

        return "PR/{$date}/{$formattedCount}";
    }

    public function approve()
{
    $this->update(['status' => 'APPROVED']);
}

public function reject()
{
    $this->update(['status' => 'REJECTED']);
}
}