<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'po_number', 'purchase_request_id', 'supplier_id', 'po_date', 
        'expected_delivery_date', 'subtotal', 'tax_percent', 
        'tax_amount', 'grand_total', 'status', 'notes', 'created_by'
    ];

    protected $casts = [
        'po_date' => 'date',
        'expected_delivery_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($po) {
            $po->created_by = Auth::id();
            if (!$po->po_number) {
                $po->po_number = 'PO-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
            }
        });
    }

    // Relasi ke Supplier
    public function supplier() { 
        return $this->belongsTo(Supplier::class); 
    }

    public function items() { 
        return $this->hasMany(PurchaseOrderItem::class); 
    }

    public function pr() { 
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id'); 
    }

    public function creator() { 
        return $this->belongsTo(User::class, 'created_by'); 
    }
}