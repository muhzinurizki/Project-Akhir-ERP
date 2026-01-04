<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

class GoodsReceipt extends Model
{
  protected $fillable = [
    'gr_number',
    'gr_date',
    'purchase_order_id',
    'warehouse_id',
    'received_by',
    'note',
  ];

  protected $casts = [
    'gr_date' => 'date',
  ];

  /**
   * Boot function untuk Auto-Numbering GR
   */
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      if (!$model->gr_number) {
        $model->gr_number = self::generateGrNumber();
      }
    });
  }

  /**
   * Logic Generate Nomor GR: GR/YYYYMMDD/0001
   */
  public static function generateGrNumber(): string
  {
    $date = now()->format('Ymd');
    // Gunakan today() agar formatnya YYYY-MM-DD sesuai kolom created_at di DB
    $count = self::whereDate('created_at', today())->count() + 1;
    return "GR/{$date}/" . str_pad($count, 4, '0', STR_PAD_LEFT);
  }

  /* =======================
   |  RELATIONS
   ======================= */

  public function items(): HasMany
  {
    return $this->hasMany(GoodsReceiptItem::class);
  }

  public function purchaseOrder(): BelongsTo
  {
    return $this->belongsTo(PurchaseOrder::class);
  }

  public function warehouse(): BelongsTo
  {
    return $this->belongsTo(Warehouse::class);
  }

  public function receiver(): BelongsTo
  {
    return $this->belongsTo(User::class, 'received_by');
  }

  /**
   * Menghubungkan GR ke tabel Mutasi Stok secara Polymorphic
   */
  public function stockMutations(): MorphMany
  {
    return $this->morphMany(StockMutation::class, 'reference');
  }

  /* =======================
   |  DOMAIN LOGIC
   ======================= */

  /**
   * Cek apakah GR boleh dibuat dari PO ini
   */
  public static function canReceive(PurchaseOrder $po): bool
  {
    // PO harus sudah diapprove DAN belum full received
    return $po->status === 'APPROVED'
      && $po->items()->whereRaw('received_quantity < quantity')->exists();
  }

  /**
   * Update Status PO ke 'CLOSED' jika semua item sudah diterima penuh
   */
  public function updateParentPoStatus(): void
  {
    $po = $this->purchaseOrder;

    $isFullReceived = !$po->items()
      ->whereRaw('received_quantity < quantity')
      ->exists();

    if ($isFullReceived) {
      $po->update(['status' => 'CLOSED']);
    }
  }
}