<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();

            $table->string('gr_number')->unique();
            $table->date('gr_date');

            // Relasi utama
            $table->foreignId('purchase_order_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('warehouse_id')
                  ->constrained()
                  ->restrictOnDelete();

            // User penerima
            $table->foreignId('received_by')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
