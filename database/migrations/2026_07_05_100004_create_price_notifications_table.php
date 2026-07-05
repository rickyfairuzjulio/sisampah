<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_notifications', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('trash_category_id')->nullable()->constrained('trash_categories')->onDelete('cascade');
            $table->enum('tipe', [
                'harga_naik', 'harga_turun', 'harga_drastis',
                'belum_update', 'terlalu_rendah', 'terlalu_tinggi',
            ]);
            $table->string('judul');
            $table->text('pesan');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index('user_id');
            $table->index('trash_category_id');
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_notifications');
    }
};
