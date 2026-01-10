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
    Schema::create('ar_payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sales_invoice_id')->constrained()->onDelete('cascade');
        $table->date('payment_date');
        $table->decimal('amount', 15, 2);
        $table->string('payment_method'); // Transfer, Cash, Check
        $table->string('reference_number')->nullable(); // No. Bukti Transfer / Ref Bank
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
        Schema::dropIfExists('ar_payments');
    }
};
