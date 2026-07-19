<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('trash_category_id')->constrained('trash_categories')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'trash_category_id']);
            $table->index('user_id');
            $table->index('trash_category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_favorites');
    }
};
