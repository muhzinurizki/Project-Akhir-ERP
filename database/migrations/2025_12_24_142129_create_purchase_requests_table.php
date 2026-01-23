<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('purchase_requests', function (Blueprint $col) {
      $col->id();
      $col->string('pr_number')->unique();
      $col->date('request_date');
      $col->foreignId('user_id')->constrained('users'); // Pemohon
      $col->text('note')->nullable();

      // Status Logic
      $col->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'CANCELLED'])->default('PENDING');
      $col->foreignId('approved_by')->nullable()->constrained('users'); // Siapa yang approve
      $col->timestamp('approved_at')->nullable();

      $col->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('purchase_requests');
  }
};
