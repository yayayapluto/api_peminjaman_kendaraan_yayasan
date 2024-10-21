<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

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
            "id_vehicle" => Str::uuid(),
            "brand" => fake()->unique()->word(),
            "model" => fake()->word(),
            "color" => fake()->colorName(),
            "nopol" => fake()->asciify("******"),
            "is_available" => fake()->boolean(),
        ];
    }
}
