<?php

namespace Database\Seeders;

use App\Models\ContactCategory;
use Illuminate\Database\Seeder;

class ContactCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Contact',
            'Client',
            'Supplier',
            'Lead',
            'Employee',
        ];
        foreach ($categories as $category) {
            ContactCategory::firstOrCreate(['name' => $category]);
        }
    }
}
