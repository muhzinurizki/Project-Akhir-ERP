<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('stock_ledgers', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')->constrained()->onDelete('cascade');
      $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
      $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Record User

      $table->bigInteger('quantity'); // Integer - Positif untuk IN, Negatif untuk OUT
      $table->bigInteger('balance_after'); // Integer - Saldo setelah transaksi

      $table->enum('type', ['IN', 'OUT']); // Hanya IN dan OUT
      $table->string('reference')->nullable();
      $table->text('note')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('stock_ledgers');
  }
};
