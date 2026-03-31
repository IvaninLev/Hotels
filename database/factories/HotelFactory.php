<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        $city = City::inRandomOrder()->first();

        return [
            'name' => $this->faker->company . ' Hotel',
            'description' => $this->faker->paragraph(),
            'images' => [
                'app/hotels/hotel_2.jpg',
                'app/hotels/hotel_3.jpg',
            ],
            'rating' => $this->faker->randomFloat(1, 3.5, 5.0),
            'address' => $this->faker->address(),

            'city_id' => $city->id,
            'country_id' => $city->country_id,
        ];
    }
}
