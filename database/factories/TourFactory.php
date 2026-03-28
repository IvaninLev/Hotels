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
            'images' => ['tours/tour_1.jpg', 'tours/tour_2.jpg'],
            'base_price' => $this->faker->randomFloat(2, 500, 3000),

            'active_from' => $this->faker->time(),
            'active_to' => $this->faker->time(),

            'hotel_id' => $hotel->id,
            'country_id' => $countryId,
            'city_id' => $hotel->city_id,
        ];
    }
}
