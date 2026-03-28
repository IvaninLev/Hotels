<?php

namespace Database\Factories;

use App\Models\Airport;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class AirportFactory extends Factory
{
    protected $model = Airport::class;

    public function definition(): array
    {
        $city = City::inRandomOrder()->first();

        return [
            'city_id' => $city->id,
            'airport_name' => $this->faker->city() . ' International Airport',
            'price_diff' => $this->faker->randomFloat(2, 0, 150),
        ];
    }
}
