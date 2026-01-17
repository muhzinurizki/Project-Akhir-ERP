<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'so_number',
        'customer_id',
        'order_date',
        'status', // DRAFT, CONFIRMED, CANCELLED
        'note',
        'user_id'
    ];

    /**
     * Relasi ke Customer (Satu SO dimiliki satu Pelanggan)
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi ke User (Sales/Staff yang menginput)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Items (Satu SO memiliki banyak barang)
     */
    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    /**
     * Relasi ke Delivery Orders (Satu SO bisa dikirim dalam beberapa pengiriman)
     */
    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    /**
     * Method Helper: Cek apakah SO sudah bisa dibuatkan DO
     */
    public function isConfirmable()
    {
        return $this->status === 'CONFIRMED';
    }
}