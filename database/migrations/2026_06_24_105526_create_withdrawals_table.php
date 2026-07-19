<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('nominal', 12, 2);
            $table->enum('metode', ['tunai', 'transfer']);
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->string('foto_resi')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
