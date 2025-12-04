<?php

namespace Database\Factories;

use App\Enums\ContactStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'type_id' => fake()->numberBetween(1, 2),
            'date_of_birth' => fake()->date(),
            'country_id' => 2,
            'city_id' => 1,
            'center_id' => 1,
            'status' => ContactStatus::Active,
        ];
    }
}
