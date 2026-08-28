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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_sampah_id')->constrained('bank_sampahs')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Terlapor / Pelanggar
            $table->foreignId('reporter_id')->nullable()->constrained('users')->nullOnDelete(); // Admin / Petugas Pelapor
            $table->string('user_name');
            $table->string('user_role')->default('Warga Nasabah');
            $table->string('phone')->nullable();
            $table->string('tipe'); // unsegregated, suspicious, missed_pickup, hazardous_material, other
            $table->string('tipe_label');
            $table->text('deskripsi');
            $table->string('sanksi')->nullable();
            $table->integer('poin_penalti')->default(0);
            $table->string('bukti_foto')->nullable();
            $table->string('status')->default('pending'); // pending, in_review, resolved, dismissed
            $table->text('catatan_penyelesaian')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
