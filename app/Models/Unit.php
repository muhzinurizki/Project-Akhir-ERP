<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    /**
     * Relasi ke model Product
     * Satu satuan (Unit) bisa dimiliki oleh banyak Produk
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}