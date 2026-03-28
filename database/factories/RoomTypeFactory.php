<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    protected $model = RoomType::class;


    public function definition(): array
    {
        $types = [
            'Standard Room',
            'Superior Room',
            'Deluxe Room',
            'Family Room',
            'Junior Suite',
            'Executive Suite',
            'Panorama View Room',
            'Sea View Room',
            'Mountain View Room',
            'Business Room'
        ];

        return [
            'room_type' => $this->faker->randomElement($types),
            'max_persons' => $this->faker->numberBetween(1, 4),
            'price_per_person' => $this->faker->numberBetween(40, 150),
            'hotel_id' => Hotel::factory(),
            'is_base' => false,
        ];
    }
}
