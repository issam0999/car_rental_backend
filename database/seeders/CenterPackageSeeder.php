<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['name' => 'Free', 'description' => 'Free', 'level' => '1', 'paid' => 0, 'status' => 1],
            ['name' => 'Start', 'description' => 'start', 'level' => '2', 'paid' => 1, 'status' => 1],
            ['name' => 'Run', 'description' => 'Run', 'level' => '3', 'paid' => 1, 'status' => 1],
            ['name' => 'Grow', 'description' => 'Grow', 'level' => '4', 'paid' => 1, 'status' => 1],
            ['name' => 'Custom', 'description' => 'Custom Package', 'level' => '5', 'paid' => 1, 'status' => 1],
        ];

        DB::table('center_packages')->insert($rows
        );
    }
}
