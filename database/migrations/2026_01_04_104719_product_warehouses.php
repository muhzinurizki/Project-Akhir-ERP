<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('product_warehouses', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')->constrained()->onDelete('cascade');
      $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
      $table->decimal('quantity', 15, 3)->default(0); // 3 desimal untuk presisi kain/benang
      $table->timestamps();
      $table->unique(['product_id', 'warehouse_id']); // Satu baris per produk per gudang
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_warehouses');
  }
};
