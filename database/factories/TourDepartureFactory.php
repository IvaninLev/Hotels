<?php

namespace Database\Factories;

use App\Models\Tour;
use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourDepartureFactory extends Factory
{
    public function definition()
    {
        $departureDate = $this->faker->dateTimeBetween('2025-05-01', '2025-09-01');
        $arrivalDate = (clone $departureDate)->modify('+' . $this->faker->numberBetween(1, 12) . ' hours');
        $returnDate = (clone $departureDate)->modify('+' . $this->faker->numberBetween(3, 14) . ' days');
        $returnArrivalDate = (clone $returnDate)->modify('+' . $this->faker->numberBetween(1, 12) . ' hours');

        return [
            'tour_id' => Tour::inRandomOrder()->value('id') ?? Tour::factory(),
            'airport_id' => Airport::inRandomOrder()->value('id') ?? Airport::factory(),
            'return_airport_id' => Airport::inRandomOrder()->value('id') ?? Airport::factory(),
            'departure_date' => $departureDate->format('Y-m-d H:i:s'),
            'arrival_date' => $arrivalDate->format('Y-m-d H:i:s'),
            'return_date' => $returnDate->format('Y-m-d H:i:s'),
            'return_arrival_date' => $returnArrivalDate->format('Y-m-d H:i:s'),
            'night_count'=> $this->faker->randomElement([7,10,12,14]),
            'extra_price' => $this->faker->randomElement([0,0,1000,1500,2000])
        ];
    }
}
