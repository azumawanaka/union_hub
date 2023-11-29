<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceType::factory()->create([
            'name' => 'Beauty',
        ]);
        ServiceType::factory()->create([
            'name' => 'Spa and Wellness',
        ]);
    }
}
