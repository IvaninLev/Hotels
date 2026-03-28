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
        if (!$city) {
            throw new \RuntimeException('No cities found. Seed cities before hotels.');
        }

        return [
            'name' => $this->faker->company . ' Hotel',
            'description' => $this->faker->paragraph(),
            'images' => ['hotels/hotel_1.jpg', 'hotels/hotel_2.jpg', 'hotels/hotel_3.jpg',],
            'rating' => $this->faker->randomFloat(1, 3.5, 5.0),
            'address' => $this->faker->address(),

            'city_id' => $city->id,
            'country_id' => $city->country_id,
        ];
    }
}
