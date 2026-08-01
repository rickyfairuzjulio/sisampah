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
        Schema::table('bank_sampahs', function (Blueprint $table) {
            if (!Schema::hasColumn('bank_sampahs', 'radius_layanan')) {
                $table->integer('radius_layanan')->default(3000)->after('hari_operasional'); // default 3000 meters (3 km)
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_sampahs', function (Blueprint $table) {
            if (Schema::hasColumn('bank_sampahs', 'radius_layanan')) {
                $table->dropColumn('radius_layanan');
            }
        });
    }
};
