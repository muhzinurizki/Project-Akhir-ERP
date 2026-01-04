<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('purchase_request_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('purchase_request_id')->constrained()->onDelete('cascade');
      $table->foreignId('product_id')->constrained(); // Barang yang diminta
      $table->decimal('qty', 15, 2);
      $table->string('unit_name'); // Simpan nama satuan saat itu (untuk record)
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('purchase_request_items');
  }
};
