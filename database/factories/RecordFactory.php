<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "id_record" => Str::uuid(),
            "id_user" => User::inRandomOrder()->first()->id_user,
            "id_vehicle" => Vehicle::inRandomOrder()->first()->id_vehicle,
            "driver_name" => fake()->firstNameMale,
            "service" => fake()->randomElement(["internal", "external"]),
            "image" => fake()->imageUrl(200, 200),
            "from_address" => fake()->address,
            "from_lon" => fake()->longitude(),
            "from_lat" => fake()->latitude(),
            "to_address" => fake()->address,
            "to_lon" => fake()->longitude(),
            "to_lat" => fake()->latitude(),
            "status" => fake()->randomElement(["new", "apr", "rej"]),
        ];
    }
}
