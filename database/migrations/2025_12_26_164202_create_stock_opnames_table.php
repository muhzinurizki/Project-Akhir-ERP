<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id();

            $table->foreignId('warehouse_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('item_type', ['raw_material', 'product']);
            $table->unsignedBigInteger('item_id');

            $table->decimal('qty_system', 15, 3);
            $table->decimal('qty_real', 15, 3);
            $table->decimal('selisih', 15, 3);

            $table->enum('status', ['draft', 'confirmed', 'approved'])
                ->default('draft');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['warehouse_id']);
            $table->index(['item_type', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};
