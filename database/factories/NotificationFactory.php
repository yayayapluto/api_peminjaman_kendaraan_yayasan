<?php

namespace Database\Factories;

use App\Models\Record;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "id_notification" => Str::uuid(),
            "id_user" => User::inRandomOrder()->first()->id_user,
            "id_record" => Record::inRandomOrder()->first()->id_vehicle,
            "status" => fake()->randomElement(["apr", "rej"]),
            "message" => fake()->sentence(),
            "is_read" => fake()->boolean(),
        ];
    }
}
