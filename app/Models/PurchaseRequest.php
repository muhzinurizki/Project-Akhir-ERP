<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pr_number',
        'request_date',
        'warehouse_id',
        'status',
        'requested_by',
        'approved_by',
        'approved_at',
        'note',
    ];

    protected $casts = [
        'request_date' => 'date',
        'approved_at' => 'datetime',
    ];

    /* =======================
     |  RELATIONS
     ======================= */

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* =======================
     |  BUSINESS LOGIC
     ======================= */

    public function isEditable(): bool
    {
        return $this->status === 'DRAFT';
    }

    public function canBeApproved(): bool
    {
        return $this->status === 'SUBMITTED';
    }

    public function submit(): void
    {
        if ($this->status !== 'DRAFT') {
            throw new \Exception('PR hanya bisa disubmit dari status DRAFT');
        }

        $this->update([
            'status' => 'SUBMITTED',
        ]);
    }

    public function approve(int $userId): void
    {
        if ($this->status !== 'SUBMITTED') {
            throw new \Exception('PR hanya bisa di-approve dari status SUBMITTED');
        }

        $this->update([
            'status' => 'APPROVED',
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);
    }

    public function reject(int $userId): void
    {
        if ($this->status !== 'SUBMITTED') {
            throw new \Exception('PR hanya bisa di-reject dari status SUBMITTED');
        }

        $this->update([
            'status' => 'REJECTED',
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);
    }
}
