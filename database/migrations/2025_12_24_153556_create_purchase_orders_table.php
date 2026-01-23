<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('purchase_orders', function (Blueprint $table) {
      $table->id();
      $table->string('po_number')->unique();
      $table->foreignId('purchase_request_id')->nullable()->constrained('purchase_requests')->onDelete('set null');

      // Menggunakan supplier_id sesuai tabel yang Anda miliki
      $table->foreignId('supplier_id')->constrained('suppliers');

      $table->date('po_date');
      $table->date('expected_delivery_date')->nullable();

      // Financials
      $table->decimal('subtotal', 15, 2)->default(0);
      $table->decimal('tax_percent', 5, 2)->default(11); // PPN
      $table->decimal('tax_amount', 15, 2)->default(0);
      $table->decimal('grand_total', 15, 2)->default(0);

      $table->enum('status', ['DRAFT', 'SENT', 'RECEIVED', 'CANCELLED'])->default('DRAFT');
      $table->text('notes')->nullable();
      $table->foreignId('created_by')->constrained('users');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('purchase_orders');
  }
};
