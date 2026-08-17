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
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('email');
            }
        });

        Schema::table('trash_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('trash_categories', 'harga_minimal')) {
                $table->decimal('harga_minimal', 12, 2)->nullable()->after('harga_per_kg');
            }
            if (!Schema::hasColumn('trash_categories', 'harga_maksimal')) {
                $table->decimal('harga_maksimal', 12, 2)->nullable()->after('harga_minimal');
            }
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            if (!Schema::hasColumn('withdrawals', 'bukti_mutasi')) {
                $table->string('bukti_mutasi')->nullable()->after('foto_resi');
            }
            if (!Schema::hasColumn('withdrawals', 'status_penerimaan')) {
                $table->string('status_penerimaan', 50)->default('pending')->after('status');
            }
        });

        Schema::table('bank_sampahs', function (Blueprint $table) {
            if (!Schema::hasColumn('bank_sampahs', 'kas_unit')) {
                $table->decimal('kas_unit', 12, 2)->default(5000000.00)->after('radius_layanan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('trash_categories', function (Blueprint $table) {
            if (Schema::hasColumn('trash_categories', 'harga_minimal')) {
                $table->dropColumn('harga_minimal');
            }
            if (Schema::hasColumn('trash_categories', 'harga_maksimal')) {
                $table->dropColumn('harga_maksimal');
            }
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            if (Schema::hasColumn('withdrawals', 'bukti_mutasi')) {
                $table->dropColumn('bukti_mutasi');
            }
            if (Schema::hasColumn('withdrawals', 'status_penerimaan')) {
                $table->dropColumn('status_penerimaan');
            }
        });

        Schema::table('bank_sampahs', function (Blueprint $table) {
            if (Schema::hasColumn('bank_sampahs', 'kas_unit')) {
                $table->dropColumn('kas_unit');
            }
        });
    }
};
