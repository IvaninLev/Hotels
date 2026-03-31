<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\City;
use Illuminate\Database\Seeder;

class AirportsSeeder extends Seeder
{
    public function run(): void
    {
        City::inRandomOrder()->take(10)->get()->each(function ($city) {
            Airport::factory()
                ->count(2000)
                ->create([
                    'city_id' => $city->id,
                ]);
        });
    }
}
