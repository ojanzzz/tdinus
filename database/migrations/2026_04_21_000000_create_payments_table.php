<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pelatihan_id')->constrained('pelatihans')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('invoice_no')->unique();
            $table->enum('status', ['pending', 'paid', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('bukti_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

