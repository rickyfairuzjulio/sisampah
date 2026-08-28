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
        // 1. Stok Fisik Gudang Unit per Kategori Sampah
        Schema::create('warehouse_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_sampah_id')->constrained('bank_sampahs')->cascadeOnDelete();
            $table->foreignId('trash_category_id')->constrained('trash_categories')->cascadeOnDelete();
            $table->decimal('stok_kg', 12, 2)->default(0);
            $table->decimal('kapasitas_maks_kg', 12, 2)->default(5000);
            $table->string('lokasi_rak')->nullable()->default('Gudang Utama A');
            $table->string('status_kondisi')->default('Siap Angkut Pengepul');
            $table->timestamps();

            $table->unique(['bank_sampah_id', 'trash_category_id']);
        });

        // 2. Transaksi Penjualan ke Pengepul / Pabrik Daur Ulang (Offtaker Sales)
        Schema::create('offtaker_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_sampah_id')->constrained('bank_sampahs')->cascadeOnDelete();
            $table->foreignId('trash_category_id')->constrained('trash_categories')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_pembeli'); // Nama PT / Pengepul / Mitra
            $table->decimal('berat_kg', 12, 2);
            $table->decimal('harga_per_kg', 14, 2);
            $table->decimal('total_pendapatan', 16, 2);
            $table->string('foto_nota')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default('selesai'); // selesai, pending, dibatalkan
            $table->timestamps();
        });

        // 3. Produk Daur Ulang & Upcycling (Ekonomi Sirkular)
        Schema::create('upcycling_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_sampah_id')->constrained('bank_sampahs')->cascadeOnDelete();
            $table->foreignId('trash_category_id')->nullable()->constrained('trash_categories')->nullOnDelete(); // Bahan baku
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->string('bahan_baku_keterangan')->nullable();
            $table->decimal('jumlah_bahan_kg', 10, 2)->default(0);
            $table->integer('stok_qty')->default(0);
            $table->string('satuan')->default('Pcs'); // Pcs, Kg, Liter, Botol
            $table->decimal('harga_satuan', 14, 2)->default(0);
            $table->decimal('total_valuasi', 16, 2)->default(0);
            $table->string('pengrajin')->default('Kader PKK / Karang Taruna');
            $table->string('foto_url')->nullable();
            $table->string('status')->default('tersedia'); // tersedia, habis, dipesan
            $table->timestamps();
        });

        // 4. Buku Besar Sirkulasi Material & Log Mutasi Fisik Sampah
        Schema::create('material_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_sampah_id')->constrained('bank_sampahs')->cascadeOnDelete();
            $table->foreignId('trash_category_id')->nullable()->constrained('trash_categories')->nullOnDelete();
            $table->string('tipe'); // inbound (setoran warga), sale (jual pengepul), upcycling (alih karya)
            $table->string('tipe_label');
            $table->string('kategori_nama');
            $table->decimal('berat_kg', 12, 2);
            $table->decimal('nilai_rp', 16, 2)->default(0);
            $table->string('output_desc')->nullable(); // misal: "50 pcs Tas Belanja" atau "+Rp 11.250.000"
            $table->string('pihak_terkait'); // misal: Nama Nasabah, Nama PT Pengepul, Tim PKK
            $table->string('status')->default('Selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_ledgers');
        Schema::dropIfExists('upcycling_products');
        Schema::dropIfExists('offtaker_sales');
        Schema::dropIfExists('warehouse_stocks');
    }
};
