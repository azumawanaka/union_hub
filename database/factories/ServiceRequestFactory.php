<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceRequest>
 */
class ServiceRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::factory()->create(),
            'budget' => fake()->randomFloat(3, 0, 0),
            'preferred_date' => Carbon::now()->addDay()->toDateString(),
            'preferred_time' => Carbon::now()->addDay()->toTimeString(),
            'location' => fake()->city,
            'user_id' => User::factory()->create(),
            'status' => 'pending',
            'details' => 'lorem ipsum dolor sit amet',
        ];
    }
}
