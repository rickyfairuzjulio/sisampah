<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->bigInteger('total_poin_lingkungan')->default(0);
            $table->decimal('total_berat_kg', 10, 2)->default(0);
            $table->integer('jumlah_transaksi')->default(0);
            $table->timestamps();

            $table->index('total_poin_lingkungan');
            $table->index('total_berat_kg');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaderboards');
    }
};
