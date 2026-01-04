<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockOpname extends Model
{
    protected $fillable = [
        'warehouse_id',
        'item_type', // product, raw_material, etc.
        'item_id',
        'qty_system',
        'qty_real',
        'selisih',
        'status', // PENDING, ADJUSTED, REJECTED
        'approved_by',
        'note'
    ];

    protected $casts = [
        'qty_system' => 'decimal:3',
        'qty_real' => 'decimal:3',
        'selisih' => 'decimal:3',
    ];

    /**
     * Boot function untuk logika otomatis
     */
    protected static function boot()
    {
        parent::boot();

        // Otomatis hitung selisih sebelum simpan/update
        static::saving(function ($model) {
            $model->selisih = $model->qty_real - $model->qty_system;
        });
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Perbaikan Relasi Item
     * Jika Anda menggunakan satu tabel Produk saja:
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    /**
     * Alternatif: Jika menggunakan Polymorphic (Lebih Disarankan)
     * Ini memungkinkan item_id merujuk ke tabel mana saja (Product, Yarn, Fabric)
     */
    public function stockable()
    {
        return $this->morphTo(null, 'item_type', 'item_id');
    }
}