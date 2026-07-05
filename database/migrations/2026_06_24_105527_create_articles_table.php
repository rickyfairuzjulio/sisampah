<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten');
            $table->string('kategori');
            $table->string('gambar')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index('kategori');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
