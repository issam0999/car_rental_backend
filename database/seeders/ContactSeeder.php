<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['center_id' => 1, 'type_id' => 1, 'name' => 'Issam Hajj Ali', 'email' => 'isamhajjali@gmail.com'], ];
        DB::table('contacts')->insert($rows);
        DB::table('users')->update(['contact_id' => 1]);
    }
}
