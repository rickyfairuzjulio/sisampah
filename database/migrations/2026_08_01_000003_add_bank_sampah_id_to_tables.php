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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bank_sampah_id')) {
                $table->foreignId('bank_sampah_id')->nullable()->after('id')->constrained('bank_sampahs')->onDelete('set null');
            }
        });

        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'bank_sampah_id')) {
                $table->foreignId('bank_sampah_id')->nullable()->after('user_id')->constrained('bank_sampahs')->onDelete('set null');
            }
        });

        Schema::table('trash_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('trash_categories', 'bank_sampah_id')) {
                $table->foreignId('bank_sampah_id')->nullable()->after('id')->constrained('bank_sampahs')->onDelete('set null');
            }
        });

        Schema::table('scan_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('scan_logs', 'bank_sampah_id')) {
                $table->foreignId('bank_sampah_id')->nullable()->after('user_id')->constrained('bank_sampahs')->onDelete('set null');
            }
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            if (!Schema::hasColumn('withdrawals', 'bank_sampah_id')) {
                $table->foreignId('bank_sampah_id')->nullable()->after('user_id')->constrained('bank_sampahs')->onDelete('set null');
            }
        });

        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'bank_sampah_id')) {
                $table->foreignId('bank_sampah_id')->nullable()->after('id')->constrained('bank_sampahs')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', fn (Blueprint $table) => $table->dropForeign(['bank_sampah_id'])->dropColumn('bank_sampah_id'));
        Schema::table('transactions', fn (Blueprint $table) => $table->dropForeign(['bank_sampah_id'])->dropColumn('bank_sampah_id'));
        Schema::table('trash_categories', fn (Blueprint $table) => $table->dropForeign(['bank_sampah_id'])->dropColumn('bank_sampah_id'));
        Schema::table('scan_logs', fn (Blueprint $table) => $table->dropForeign(['bank_sampah_id'])->dropColumn('bank_sampah_id'));
        Schema::table('withdrawals', fn (Blueprint $table) => $table->dropForeign(['bank_sampah_id'])->dropColumn('bank_sampah_id'));
        Schema::table('articles', fn (Blueprint $table) => $table->dropForeign(['bank_sampah_id'])->dropColumn('bank_sampah_id'));
    }
};
