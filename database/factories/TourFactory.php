<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    protected $model = Tour::class;

    public function definition(): array
    {
        $hotel = Hotel::inRandomOrder()->first() ?? Hotel::factory()->create();
        $city = City::find($hotel->city_id);
        $countryId = $hotel->country_id ?? $city?->country_id;
        if (!$countryId) {
            $countryId = Country::inRandomOrder()->value('id');
        }

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->text(),
            'persons' => $this->faker->numberBetween(1, 4),
            'images' => [
                'app/hotels/hotel_2.jpg',
                'app/hotels/hotel_3.jpg',
            ],
            'base_price' => $this->faker->randomFloat(2, 500, 3000),

            'active_from' => $this->faker->dateTimeBetween('2026-01-01', '2027-01-01')->format('Y-m-d H:i:s'),
            'active_to' => $this->faker->dateTimeBetween('2027-01-01', '2027-12-31')->format('Y-m-d H:i:s'),

            'hotel_id' => $hotel->id,
            'country_id' => $countryId,
            'city_id' => $hotel->city_id,
        ];
    }
}
