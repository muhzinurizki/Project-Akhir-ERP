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
    Schema::create('sales_orders', function (Blueprint $table) {
      $table->id();
      $table->string('so_number')->unique();
      $table->foreignId('customer_id')->constrained();
      $table->date('order_date');
      $table->enum('status', ['DRAFT', 'CONFIRMED', 'CANCELLED'])->default('DRAFT');
      $table->text('note')->nullable();
      $table->foreignId('user_id')->constrained(); // Sales yang input
      $table->timestamps();
    });

    Schema::create('sales_order_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('sales_order_id')->constrained()->onDelete('cascade');
      $table->foreignId('product_id')->constrained();
      $table->integer('quantity');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sales_orders');
  }
};
