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
        Schema::table('scan_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('scan_logs', 'total_harga')) {
                $table->decimal('total_harga', 12, 2)->default(0)->after('confidence');
            }
            if (!Schema::hasColumn('scan_logs', 'total_berat')) {
                $table->decimal('total_berat', 8, 2)->default(0)->after('total_harga');
            }
            if (!Schema::hasColumn('scan_logs', 'object_count')) {
                $table->integer('object_count')->default(1)->after('total_berat');
            }
            if (!Schema::hasColumn('scan_logs', 'eco_impact')) {
                $table->json('eco_impact')->nullable()->after('object_count');
            }
            if (!Schema::hasColumn('scan_logs', 'items_detail')) {
                $table->json('items_detail')->nullable()->after('eco_impact');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scan_logs', function (Blueprint $table) {
            $table->dropColumn(['total_harga', 'total_berat', 'object_count', 'eco_impact', 'items_detail']);
        });
    }
};
