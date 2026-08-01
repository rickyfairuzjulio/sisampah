<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            BankSampahSeeder::class,
            TrashCategorySeeder::class,
            UserSeeder::class,
            ArticleSeeder::class,
            PriceHistorySeeder::class,
            CompetitionSeeder::class,
            BankSampahFinanceSeeder::class,
        ]);
    }
}
