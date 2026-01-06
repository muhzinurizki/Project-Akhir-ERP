<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (opsional jika sudah jamak/customers)
     */
    protected $table = 'customers';

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'address',
        'contact',
    ];

    /**
     * Relasi: Satu customer memiliki banyak Sales Invoice (Piutang)
     */
    public function salesInvoices()
    {
        return $this->hasMany(SalesInvoice::class);
    }

    /**
     * Accessor: Menghitung total sisa piutang yang belum dibayar oleh customer ini
     */
    public function getBalanceAttribute()
    {
        return $this->salesInvoices()
                    ->whereIn('status', ['unpaid', 'partial', 'overdue'])
                    ->sum('total_amount') - $this->salesInvoices()->sum('received_amount');
    }
}