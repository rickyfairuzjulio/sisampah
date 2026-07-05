<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('trash_category_id')->constrained('trash_categories')->onDelete('restrict');
            $table->decimal('berat_kg', 8, 2);
            $table->decimal('harga_per_kg', 10, 2);
            $table->decimal('total_rp', 12, 2);
            $table->enum('tipe_setoran', ['jemput', 'mandiri']);
            $table->enum('status', ['pending', 'selesai'])->default('pending');
            $table->string('foto_bukti')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('petugas_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
