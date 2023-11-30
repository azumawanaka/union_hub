<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceType>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_type_id' => ServiceType::factory()->create(),
            'title' => 'Eyelash extensions',
            'added_by' => User::factory()->create(),
            'client_id' => Client::factory()->create(),
        ];
    }
}
