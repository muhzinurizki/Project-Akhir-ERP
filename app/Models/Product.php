<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use App\Models\Unit;

class Product extends Model
{
    protected $fillable = [
        'sku', 'name', 'product_category_id',
        'unit_id', 'type', 'is_active'
    ];

public function category()
{
    // Pastikan foreign key-nya tertulis 'product_category_id'
    return $this->belongsTo(ProductCategory::class, 'product_category_id');
}

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

