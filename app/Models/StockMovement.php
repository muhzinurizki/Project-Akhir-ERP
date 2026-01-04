<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StockMovement extends Model
{
  protected $fillable = [
    'product_id',
    'warehouse_id',
    'quantity',
    'reference',
    'type',
    'created_by',
    'note',
  ];

  /**
   * Logic Otomatis: Update Saldo & Catat Mutasi
   */
  protected static function booted()
  {
    static::created(function ($movement) {
      // 1. Update atau Buat Saldo di Gudang
      $stock = ProductWarehouse::firstOrCreate(
        ['product_id' => $movement->product_id, 'warehouse_id' => $movement->warehouse_id],
        ['quantity' => 0]
      );

      $before = $stock->quantity;

      // 2. Hitung Saldo Baru
      if ($movement->type === 'IN') {
        $stock->increment('quantity', $movement->quantity);
      } else {
        $stock->decrement('quantity', $movement->quantity);
      }

      // 3. Catat di Kartu Stok (Mutations)
      StockMutation::create([
        'stock_movement_id' => $movement->id,
        'item_type' => Product::class,
        'item_id' => $movement->product_id,
        'warehouse_id' => $movement->warehouse_id,
        'mutation_type' => $movement->type,
        'qty' => $movement->quantity,
        'balance_before' => $before,
        'balance_after' => $stock->fresh()->quantity,
        'reference_type' => self::class,
        'reference_id' => $movement->id,
        'created_by' => $movement->created_by,
        'note' => $movement->note ?? $movement->reference,
      ]);
    });
  }

  /* -------------------------------------------------------------------------- */
  /* RELATIONS                                 */
  /* -------------------------------------------------------------------------- */

  public function mutation(): HasOne
  {
    return $this->hasOne(StockMutation::class);
  }

  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class);
  }

  public function warehouse(): BelongsTo
  {
    return $this->belongsTo(Warehouse::class);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  /* -------------------------------------------------------------------------- */
  /* STATIC METHODS                               */
  /* -------------------------------------------------------------------------- */

  /**
   * Metode paling cepat: Ambil langsung dari tabel Saldo
   */
  public static function getCurrentStock($productId, $warehouseId)
  {
    return ProductWarehouse::where('product_id', $productId)
      ->where('warehouse_id', $warehouseId)
      ->value('quantity') ?? 0;
  }
}