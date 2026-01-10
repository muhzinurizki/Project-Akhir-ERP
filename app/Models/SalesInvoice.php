<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
  protected $fillable = [
    'invoice_number',
    'customer_id',
    'invoice_date',
    'due_date',
    'total_amount',
    'received_amount',
    'status',
    'note',
    'created_by'
  ];

  protected $casts = [
    'invoice_date' => 'date',
    'due_date' => 'date',
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function creator()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function arPayments()
  {
    // Pastikan nama modelnya sesuai dengan model pembayaran Anda
    return $this->hasMany(ArPayment::class);
  }
}
