<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['email' => 'isamhajjali@gmail.com', 'password' => bcrypt('secret123'), 'email_verified_at' => now()]];
        DB::table('users')->insert($users);
    }
}
