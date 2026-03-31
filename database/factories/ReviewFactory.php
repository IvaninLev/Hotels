<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Review;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'was_in_hotel' => Hotel::inRandomOrder()->first()->name,
            'main_text' => $this->faker->paragraphs(3, true),
            'person_from' => $this->faker->city(),
            'flight_to' => $this->faker->city(),
            'rating' => $this->faker->numberBetween(1, 5),
            'flight_date' => $this->faker->date(),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
