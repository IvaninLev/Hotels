<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Nutrition;
use Illuminate\Database\Eloquent\Factories\Factory;

class NutritionFactory extends Factory
{
    protected $model = Nutrition::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Buffet Breakfast',
                'Half Board',
                'Full Board',
                'All Inclusive',
                'Ultra All Inclusive',
                'Room Only',
            ]),
            'code' => $this->faker->randomElement(['BB', 'HB', 'FB', 'AI', 'UAI', 'RO']),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'hotel_id' => Hotel::factory(),
            'is_base' => false,
        ];
    }

    public function base()  : static
    {
        return $this->state(fn (array $attributes) => [
            'is_base' => true,
        ]);
    }
}
