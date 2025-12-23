<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            InstansisSeeder::class,
            PeriodesSeeder::class,
            PenempatansSeeder::class,
            LogbookSeeder::class,
            JurnalSeeder::class,
            LaporanAkhirSeeder::class
        ]);
    }
}
