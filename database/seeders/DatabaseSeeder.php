<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            IndustrySeeder::class,
            CenterPackageSeeder::class,
            CurrencySeeder::class,
            CenterSeeder::class,
            ContactSeeder::class,
            ContactCategorySeeder::class,
            CenterParameterSeeder::class,
        ]);
    }
}
