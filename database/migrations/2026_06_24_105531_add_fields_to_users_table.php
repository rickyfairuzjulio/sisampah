<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('saldo', 12, 2)->default(0)->after('email');
            $table->string('rt')->nullable()->after('saldo');
            $table->string('rw')->nullable()->after('rt');
            $table->text('alamat_lengkap')->nullable()->after('rw');
            $table->string('nomor_telepon')->nullable()->after('alamat_lengkap');

            $table->index('rt');
            $table->index('rw');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['rt']);
            $table->dropIndex(['rw']);
            $table->dropColumn(['saldo', 'rt', 'rw', 'alamat_lengkap', 'nomor_telepon']);
        });
    }
};
