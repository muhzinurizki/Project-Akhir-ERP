<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounts_payables', function (Blueprint $table) {
            $table->id();

            $table->string('ap_number')->unique();

            $table->foreignId('supplier_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('purchase_order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('goods_receipt_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->date('invoice_date');
            $table->date('due_date');

            $table->decimal('total_amount', 15, 2);

            $table->enum('status', ['UNPAID', 'PAID'])
                  ->default('UNPAID');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts_payables');
    }
};
