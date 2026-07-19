<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trash_category_id')->constrained('trash_categories')->onDelete('cascade');
            $table->decimal('harga_lama', 10, 2);
            $table->decimal('harga_baru', 10, 2);
            $table->decimal('persentase_perubahan', 5, 2)->default(0);
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->text('alasan')->nullable();
            $table->timestamps();

            $table->index('trash_category_id');
            $table->index('admin_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_histories');
    }
};
