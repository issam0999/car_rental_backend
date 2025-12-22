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
            ['center_id' => 1, 'type_id' => 1, 'name' => 'Issam Hajj Ali', 'email' => 'isamhajjali@gmail.com', 'status' => 'active', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null, 'created_by' => 1, 'updated_by' => 1, 'deleted_by' => null, 'created_ip' => '127.0.0.1', 'updated_ip' => '127.0.0.1'], ];
        DB::table('contacts')->insert($rows);
        DB::table('users')->update(['contact_id' => 1]);
    }
}
