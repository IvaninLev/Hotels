<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class   HotelReviewFactory extends Factory
{
    public function definition()
    {
        return [
            'hotel_id' => Hotel::inRandomOrder()->value('id'),

            'person_name' => $this->faker->firstName(),
            'person_second_name' => $this->faker->lastName(),

            'from_city_id' => $this->faker->numberBetween(1, 5000),

            'main_text' => $this->faker->realText(180),

            'review_date' => $this->faker->dateTimeBetween('-1 year', 'now'),

            'rating_for_food' => $this->faker->numberBetween(1, 5),
            'rating_for_room' => $this->faker->numberBetween(1, 5),
            'rating_price_quality' => $this->faker->numberBetween(1, 5),
            'rating_for_beach' => $this->faker->numberBetween(1, 5),
        ];
    }
}
