<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'do_number',
        'sales_order_id',
        'warehouse_id',
        'delivery_date',
        'user_id' // Admin gudang yang memproses pengiriman
    ];

    /**
     * Relasi ke Sales Order asal
     */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    /**
     * Relasi ke Gudang asal pengiriman
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Relasi ke User (Operator Gudang)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Stock Ledgers (Rekam jejak pemotongan stok)
     * Satu DO bisa menghasilkan banyak baris ledger (satu per produk)
     */
    public function stockLedgers()
    {
        return $this->hasMany(StockLedger::class, 'reference', 'do_number');
    }
}