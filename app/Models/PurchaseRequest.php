<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class PurchaseRequest extends Model
{
  use HasFactory;

  protected $fillable = [
    'pr_number',
    'request_date',
    'user_id',
    'note',
    'status',       // Pastikan ada
    'approved_by',  // Pastikan ada
    'approved_at'   // Pastikan ada
  ];

  protected $casts = [
    'request_date' => 'date',
    'approved_at' => 'datetime',
  ];

  // Otomatis isi PR Number & User ID saat create
  protected static function booted()
  {
    static::creating(function ($pr) {
      $pr->user_id = Auth::id();
      if (!$pr->pr_number) {
        $pr->pr_number = 'PR-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
      }
    });
  }

  public function items()
  {
    return $this->hasMany(PurchaseRequestItem::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
  public function approver()
  {
    return $this->belongsTo(User::class, 'approved_by');
  }
}
