<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->string('po_number')->unique();
            $table->date('po_date');

            // Relasi utama
            $table->foreignId('purchase_request_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('supplier_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('warehouse_id')
                  ->constrained()
                  ->restrictOnDelete();

            // Status lifecycle
            $table->enum('status', [
                'DRAFT',
                'SUBMITTED',
                'APPROVED',
                'CLOSED'
            ])->default('DRAFT');

            // Approval
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
