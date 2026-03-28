<?php

namespace Database\Factories;

use App\Models\HotelFeature;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFeatureFactory extends Factory
{
    protected $model = HotelFeature::class;

    public function definition(): array
    {
        return [
            'hotel_id' => $this->faker->numberBetween(1, 5),
            'name' => $this->faker->randomElement([
                'Swimming Pool',
                'Wi-Fi',
                'SPA',
                'Parking',
                'Kids Club',
                'Restaurant',
                'Private Beach',
                'Gym',
                'Sauna',
                'Room Service',
            ]),
            'category' => $this->faker->randomElement([
                'Facilities',
                'Location',
                'Food',
                'Services',
                'Wellness',
                'Family',
                'Property',
            ]),
            'value' => $this->faker->randomElement([
                'Yes',
                'Free',
                'Paid',
                '24/7',
                'Available',
                'Premium',
                '150 m',
                'Outdoor',
                'Indoor',
                'Buffet',
            ]),
        ];
    }
}
