<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'plat_number' => fake()->regexify("[A-Z]{1} [1-9]{4} [A-Z]{1,2}"),
            'type' => fake()->sentence(1),
            'stnk' => fake()->sentence(1),
            'max_capacity' => fake()->randomNumber(),
        ];
    }
}
