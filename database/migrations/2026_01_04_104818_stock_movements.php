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
    Schema::create('stock_movements', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')->constrained();
      $table->foreignId('warehouse_id')->constrained();
      $table->decimal('quantity', 15, 3);
      $table->enum('type', ['IN', 'OUT']);
      $table->string('reference')->nullable(); // No. Surat Jalan / No. PO
      $table->text('note')->nullable();
      $table->foreignId('created_by')->constrained('users');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
  }
};
