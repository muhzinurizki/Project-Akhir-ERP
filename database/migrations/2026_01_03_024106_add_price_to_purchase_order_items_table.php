<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->after('quantity');
            $table->decimal('subtotal', 15, 2)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->dropColumn(['price', 'subtotal']);
        });
    }
};
