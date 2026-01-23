<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcInspection extends Model
{
    use HasFactory;

    protected $table = 'qc_inspections';

    protected $fillable = [
        'product_id',
        'inspector_id',
        'status',
        'note',
    ];

    /* =====================
       RELATIONSHIPS
    ===================== */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
