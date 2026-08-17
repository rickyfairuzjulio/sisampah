<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trash_categories', function (Blueprint $table) {
            $table->string('kode')->after('id');
            $table->enum('kategori', ['organik', 'anorganik', 'b3'])->default('anorganik')->after('nama');
            $table->string('jenis')->nullable()->after('kategori');
            $table->string('gambar')->nullable()->after('jenis');
            $table->decimal('harga_per_gram', 10, 4)->default(0)->after('harga_per_kg');
            $table->enum('satuan', ['kg', 'gram', 'unit'])->default('kg')->after('harga_per_gram');
            $table->enum('kualitas', ['premium', 'standar', 'rendah'])->default('standar')->after('satuan');
            $table->decimal('stok_dibutuhkan', 10, 2)->default(0)->after('kualitas');
            $table->enum('status_harga', ['naik', 'turun', 'stabil'])->default('stabil')->after('stok_dibutuhkan');
            $table->decimal('perubahan_persen', 5, 2)->default(0)->after('status_harga');
            $table->text('manfaat')->nullable()->after('deskripsi');
            $table->string('nilai_daur_ulang')->nullable()->after('manfaat');
            $table->text('tips_penyimpanan')->nullable()->after('nilai_daur_ulang');
            $table->text('tips_menjual')->nullable()->after('tips_penyimpanan');
            $table->boolean('is_archived')->default(false)->after('tips_menjual');

            $table->index('kode');
            $table->index('kategori');
            $table->index('status_harga');
            $table->index('is_archived');
        });
    }

    public function down(): void
    {
        Schema::table('trash_categories', function (Blueprint $table) {
            $table->dropIndex(['kode']);
            $table->dropIndex(['kategori']);
            $table->dropIndex(['status_harga']);
            $table->dropIndex(['is_archived']);
            $table->dropColumn([
                'kode', 'kategori', 'jenis', 'gambar', 'harga_per_gram',
                'satuan', 'kualitas', 'stok_dibutuhkan', 'status_harga',
                'perubahan_persen', 'manfaat', 'nilai_daur_ulang',
                'tips_penyimpanan', 'tips_menjual', 'is_archived',
            ]);
        });
    }
};
