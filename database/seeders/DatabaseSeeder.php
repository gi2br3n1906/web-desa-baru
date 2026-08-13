<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            VillageProfileSeeder::class,
            UmkmSeeder::class,
            TaxAndFaqSeeder::class,
            PosyanduSeeder::class,
            AdministrativeServiceSeeder::class,
            LegalProductSeeder::class,
            NewsSeeder::class,
            HeroBannerSeeder::class,
        ]);
    }
}
