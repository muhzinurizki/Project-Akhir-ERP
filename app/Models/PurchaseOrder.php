<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'po_number',
        'po_date',
        'purchase_request_id',
        'supplier_id',
        'warehouse_id',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'note',
    ];

    protected $casts = [
        'po_date' => 'date',
        'approved_at' => 'datetime',
    ];

    /* ================= Relations ================= */

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* ================= Lifecycle ================= */

    public function submit()
    {
        if ($this->status !== 'DRAFT') {
            throw new \Exception('PO tidak dapat disubmit');
        }

        $this->update(['status' => 'SUBMITTED']);
    }

    public function approve(int $userId)
    {
        if ($this->status !== 'SUBMITTED') {
            throw new \Exception('PO tidak dapat di-approve');
        }

        $this->update([
            'status' => 'APPROVED',
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);
    }

    public function isEditable(): bool
    {
        return $this->status === 'DRAFT';
    }

    public function isClosed(): bool
    {
        return $this->status === 'CLOSED';
    }
}
