<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'center_id' => 3,
            'category' => $this->faker->randomElement(['sedan', 'suv', 'hatchback', 'convertible']),
            'brand' => $this->faker->company(),
            'model' => $this->faker->word(),
            'year' => $this->faker->year(),
            'color' => $this->faker->safeColorName(),
            'plate_number' => strtoupper($this->faker->bothify('??###??')),
            'seats' => $this->faker->numberBetween(2, 7),
            'doors' => $this->faker->numberBetween(2, 5),
            'transmission' => $this->faker->randomElement(['manual', 'automatic']),
            'fuel_type' => $this->faker->randomElement(['gasoline', 'diesel', 'electric', 'hybrid']),
            'mileage' => $this->faker->numberBetween(0, 200000),
            'price_per_day' => $this->faker->randomFloat(2, 20, 200),
            'price_per_week' => $this->faker->randomFloat(2, 100, 1000),
            'price_per_month' => $this->faker->randomFloat(2, 300, 3000),
            'minimum_rental_days' => $this->faker->numberBetween(1, 7),
            'status' => $this->faker->randomElement(['available', 'maintenance', 'rented', 'unavailable']),
        ];
    }
}
