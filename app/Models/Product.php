<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku', 'name', 'product_category_id', 'unit_id', 'min_stock_level', 'description', 'is_active'
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    // Relasi ke satuan
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Relasi ke history stock
    public function stockLedgers()
    {
        return $this->hasMany(StockLedger::class);
    }

    /**
     * Accessor untuk mendapatkan saldo stok terakhir.
     * Mengambil nilai balance_after terbaru dari tabel stock_ledgers.
     */
    public function getStockTotalAttribute()
    {
        $lastLedger = DB::table('stock_ledgers')
            ->where('product_id', $this->id)
            ->orderBy('id', 'desc')
            ->first();

        return $lastLedger ? (int) $lastLedger->balance_after : 0;
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}