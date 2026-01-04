<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('goods_receipt_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Referensi langsung ke PO item (audit & partial receipt)
            $table->foreignId('purchase_order_item_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('product_id')
                  ->constrained()
                  ->restrictOnDelete();

            // Qty diterima di GR ini
            $table->decimal('quantity', 15, 4);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_items');
    }
};
