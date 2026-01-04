<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockMutation extends Model
{
    protected $fillable = [
        'stock_movement_id', // FK ke dokumen asal
        'item_type',         // App\Models\Product
        'item_id',
        'warehouse_id',
        'mutation_type',     // IN / OUT
        'reference_type',    // App\Models\StockMovement
        'reference_id',
        'qty',
        'balance_before',
        'balance_after',
        'created_by',
        'note'
    ];

    protected $casts = [
        'qty' => 'decimal:3',
        'balance_before' => 'decimal:3',
        'balance_after' => 'decimal:3',
    ];

    public function item(): MorphTo
    {
        return $this->morphTo('item', 'item_type', 'item_id');
    }

    public function reference(): MorphTo
    {
        return $this->morphTo('reference', 'reference_type', 'reference_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}