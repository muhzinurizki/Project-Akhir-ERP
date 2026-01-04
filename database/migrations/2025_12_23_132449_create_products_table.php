<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Menggunakan SKU sebagai identitas unik (sesuai error seeder Anda)
            $table->string('sku')->unique();
            $table->string('name');

            // Foreign Key untuk Category (Relasi ke tabel product_categories)
            $table->foreignId('product_category_id')->constrained()->onDelete('cascade');

            // Foreign Key untuk Unit (Relasi ke tabel units)
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');

            // Kolom tambahan sesuai data di Seeder Anda
            $table->string('type')->comment('raw_material, semi_finished, finished_goods');
            $table->boolean('is_active')->default(true);

            // Detail tambahan untuk produk tekstil
            $table->text('specification')->nullable();
            $table->decimal('selling_price', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};