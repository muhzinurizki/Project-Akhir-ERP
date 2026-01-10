<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArPayment extends Model
{
    protected $fillable = [
        'sales_invoice_id', 'payment_date', 'amount', 
        'payment_method', 'reference_number', 'note', 'created_by'
    ];

    public function salesInvoice()
    {
        return $this->belongsTo(SalesInvoice::class);
    }
}