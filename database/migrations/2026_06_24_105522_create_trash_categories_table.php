<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trash_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->decimal('harga_per_kg', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_categories');
    }
};
