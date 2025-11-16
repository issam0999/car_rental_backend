<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $rows = [
            ['name' => 'Consultancy'],
            ['name' => 'Real Estate'],
        ];

        DB::table('industries')->insert($rows
        );
    }
}
