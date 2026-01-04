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
    Schema::create('stock_mutations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('stock_movement_id')->constrained()->onDelete('cascade');
      $table->string('item_type'); // Polymorphic: App\Models\Product
      $table->unsignedBigInteger('item_id');
      $table->foreignId('warehouse_id')->constrained();
      $table->enum('mutation_type', ['IN', 'OUT']);
      $table->decimal('qty', 15, 3);
      $table->decimal('balance_before', 15, 3);
      $table->decimal('balance_after', 15, 3);
      $table->string('reference_type')->nullable(); // Asal dokumen
      $table->unsignedBigInteger('reference_id')->nullable();
      $table->foreignId('created_by')->constrained('users');
      $table->text('note')->nullable();
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
