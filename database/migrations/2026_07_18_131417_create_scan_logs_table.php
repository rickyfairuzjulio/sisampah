<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('foto_path');
            $table->foreignId('trash_category_id')->nullable()->constrained('trash_categories')->onDelete('set null');
            $table->string('ai_detected_nama')->nullable();
            $table->string('ai_detected_kategori')->nullable();
            $table->float('confidence')->nullable();
            $table->json('ai_raw_response')->nullable();
            $table->enum('status', ['matched', 'unmatched', 'reviewed'])->default('matched');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_logs');
    }
};
