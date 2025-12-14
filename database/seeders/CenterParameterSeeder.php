<?php

namespace Database\Seeders;

use App\Models\CenterParameter;
use Illuminate\Database\Seeder;

class CenterParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CenterParameter::create([
            ['center_id' => 1, 'key' => 'vat', 'value' => 1, 'required' => 1, 'type' => 'boolean'],
        ]);
    }
}
