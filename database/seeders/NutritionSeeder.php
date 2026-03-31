<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Nutrition;
use Illuminate\Database\Seeder;

class NutritionSeeder extends Seeder
{
    public function run(): void
    {
        $allOptions = [
            ['name' => 'Buffet Breakfast', 'code' => 'BB'],
            ['name' => 'Half Board', 'code' => 'HB'],
            ['name' => 'Full Board', 'code' => 'FB'],
            ['name' => 'All Inclusive', 'code' => 'AI'],
            ['name' => 'Ultra All Inclusive', 'code' => 'UAI'],
            ['name' => 'Room Only', 'code' => 'RO'],
        ];

        Hotel::all()->each(function ($hotel) use ($allOptions) {
            $shuffled = collect($allOptions)->shuffle();

            $selected = $shuffled->take(fake()->numberBetween(3, 5));

            $selected->each(function ($item, $index) use ($hotel) {
                $hotel->nutrition()->create([
                    'name' => $item['name'],
                    'code' => $item['code'],
                    'price' => fake()->randomFloat(2, 5, 50),
                    'is_base' => $index === 0,
                ]);
            });
        });
    }
}
