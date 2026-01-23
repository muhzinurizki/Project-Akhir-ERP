<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
  protected $fillable = [
    'purchase_request_id',
    'product_id',
    'qty',
    'unit_name'
  ];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function purchaseRequest()
  {
    return $this->belongsTo(PurchaseRequest::class);
  }
}
