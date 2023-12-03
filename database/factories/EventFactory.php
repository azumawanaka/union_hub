<?php

namespace Database\Factories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomStatusKey = array_rand(Event::STATUSES);
        $randomStatusValue = Event::STATUSES[$randomStatusKey];

        $randomCategoryKey = array_rand(Event::CATEGORIES);
        $randomCategoryValue = Event::CATEGORIES[$randomCategoryKey];
        return [
            'name' => fake()->name,
            'description' => fake()->text,
            'start_date' => Carbon::now()->addDay()->toDateTimeString(),
            'end_date' => Carbon::now()->addDay()->addHour()->toDateTimeString(),
            'category' => $randomCategoryValue,
            'status' => $randomStatusValue,
            'color' => fake()->hexColor,
        ];
    }
}
