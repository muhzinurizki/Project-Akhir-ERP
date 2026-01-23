<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('purchase_request_items', function (Blueprint $col) {
      $col->id();
      $col->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
      $col->foreignId('product_id')->constrained('products');
      $col->decimal('qty', 15, 2);
      $col->string('unit_name'); // Denormalisasi unit agar history tetap aman
      $col->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('purchase_request_items');
  }
};
