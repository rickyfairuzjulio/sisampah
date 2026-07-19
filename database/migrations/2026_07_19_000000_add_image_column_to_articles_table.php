<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (! Schema::hasColumn('articles', 'image')) {
                $table->string('image')->nullable()->after('kategori');
            }
        });

        // Sync values from 'gambar' column to 'image' column if image is null
        if (Schema::hasColumn('articles', 'gambar') && Schema::hasColumn('articles', 'image')) {
            DB::table('articles')->whereNull('image')->whereNotNull('gambar')->update([
                'image' => DB::raw('gambar'),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
