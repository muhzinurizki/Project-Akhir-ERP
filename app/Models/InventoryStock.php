<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'qty',
        'last_movement_at', // Mencatat kapan terakhir barang masuk/keluar
    ];

    protected $casts = [
        'qty' => 'double', // Penting untuk kain yang dihitung dalam desimal (misal: 10.5 meter)
        'last_movement_at' => 'datetime',
    ];

    /**
     * Relasi ke Produk
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke Gudang
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}