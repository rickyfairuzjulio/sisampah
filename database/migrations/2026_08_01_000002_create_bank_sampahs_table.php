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
        Schema::create('bank_sampahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bank')->unique();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('website')->nullable();
            
            // Wilayah & Alamat
            $table->text('alamat');
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('kode_pos')->nullable();
            
            // Geolocation GPS
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            // Operasional
            $table->string('jam_buka')->default('08:00');
            $table->string('jam_tutup')->default('16:00');
            $table->string('hari_operasional')->default('Senin - Sabtu');
            $table->json('wilayah_layanan')->nullable(); // Served areas list
            
            // Status: aktif, libur, nonaktif
            $table->enum('status', ['aktif', 'libur', 'nonaktif'])->default('aktif');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_sampahs');
    }
};
