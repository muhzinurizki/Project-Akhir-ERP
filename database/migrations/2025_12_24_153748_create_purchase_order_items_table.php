<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('purchase_order_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
      $table->foreignId('product_id')->constrained('products');
      $table->decimal('qty', 15, 2);
      $table->decimal('unit_price', 15, 2); // Harga dari vendor
      $table->decimal('total_price', 15, 2); // qty * unit_price
      $table->timestamps();
    });
  }

  public function down(): void
  {
    //
  }
};
