<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('purchase_requests', function (Blueprint $table) {
        $table->id();
        $table->string('pr_number')->unique(); // Contoh: PR/2026/001
        $table->date('request_date');
        $table->foreignId('user_id')->constrained(); // Siapa yang minta
        $table->text('note')->nullable();
        // Status: PENDING, APPROVED, REJECTED, COMPLETED
        $table->string('status')->default('PENDING');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
