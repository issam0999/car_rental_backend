<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('centers')->insert([[
            'name' => 'Admin',
            'description' => 'Squarely admin center',
            'country_id' => 2,
            'city_id' => 1,
            'subscription_type' => 1,
            'industry_id' => 1,
            'status' => 1,
        ], [
            'name' => 'Squarely Business Management',
            'description' => 'Squarely Business Management',
            'country_id' => 2,
            'city_id' => 1,
            'subscription_type' => 1,
            'industry_id' => 1,
            'status' => 1,
        ]]);

        DB::table('users')->update(['center_id' => 1]);

    }
}
