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
    Schema::create('sales_invoices', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_number')->unique(); // No faktur yang Anda terbitkan
        $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
        $table->date('invoice_date');
        $table->date('due_date'); // Jatuh tempo pelanggan bayar
        $table->decimal('total_amount', 15, 2);
        $table->decimal('received_amount', 15, 2)->default(0); // Uang yang sudah diterima
        $table->enum('status', ['unpaid', 'partial', 'paid', 'overdue'])->default('unpaid');
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
        Schema::dropIfExists('sales_invoices');
    }
};
