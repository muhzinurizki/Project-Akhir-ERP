<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'purchase_request_id',
        'supplier_id',
        'user_id',
        'po_date',
        'subtotal',
        'tax_percent',
        'tax_amount',
        'grand_total',
        'status',
        'note'
    ];

    // Relasi ke detail item PO
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relasi ke PR asal
    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    // Relasi ke pembuat PO (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Fungsi otomatis generate Nomor PO (Contoh: PO-20231027-0001)
    public static function generatePoNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now()->today())->count() + 1;
        return "PO-{$date}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}