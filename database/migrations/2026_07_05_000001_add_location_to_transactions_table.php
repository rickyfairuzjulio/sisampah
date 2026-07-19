<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('koordinat_lat', 10, 7)->nullable()->after('foto_bukti');
            $table->decimal('koordinat_lng', 10, 7)->nullable()->after('koordinat_lat');
            $table->text('catatan')->nullable()->after('koordinat_lng');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['koordinat_lat', 'koordinat_lng', 'catatan']);
        });
    }
};
