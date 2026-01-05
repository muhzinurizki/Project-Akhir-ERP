<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'code',
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'is_active',
    ];

    // Tambahkan ini di dalam class Supplier
    public function purchaseInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class);
    }

    // Helper untuk melihat total hutang per supplier (Balance)
    public function getTotalOwedAttribute()
    {
        return $this->purchaseInvoices()
            ->whereIn('status', ['unpaid', 'partial', 'overdue'])
            ->sum('total_amount') - $this->purchaseInvoices()->sum('paid_amount');
    }
}
