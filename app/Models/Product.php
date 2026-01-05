<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use App\Models\Unit;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku', 
        'name', 
        'product_category_id',
        'unit_id', 
        'type', 
        'is_active',
        'stock' // Tambahkan ini agar update stok via Goods Receipt tidak error
    ];

    /**
     * Relasi ke Kategori Produk
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Relasi ke Satuan (Unit)
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Scope untuk produk yang aktif saja (Opsional untuk mempermudah query)
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}