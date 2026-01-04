<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();

            $table->string('pr_number')->unique();
            $table->date('request_date');

            $table->foreignId('warehouse_id')
                ->constrained()
                ->restrictOnDelete();

            $table->enum('status', [
                'DRAFT',
                'SUBMITTED',
                'APPROVED',
                'REJECTED',
                'CLOSED',
            ])->default('DRAFT');

            $table->foreignId('requested_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();

            // Optional index
            $table->index(['status', 'request_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
