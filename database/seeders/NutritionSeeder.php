<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Nutrition;
use Illuminate\Database\Seeder;

class NutritionSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::all()->each(function ($hotel) {
            $options = [
                ['name' => 'Buffet Breakfast', 'code' => 'BB', 'is_base' => true],
                ['name' => 'Half Board', 'code' => 'HB'],
                ['name' => 'Full Board', 'code' => 'FB'],
                ['name' => 'All Inclusive', 'code' => 'AI'],
                ['name' => 'Ultra All Inclusive', 'code' => 'UAI'],
                ['name' => 'Room Only', 'code' => 'RO'],
            ];

            foreach ($options as $item) {
                $hotel->nutrition()->create([
                    'name' => $item['name'],
                    'code' => $item['code'],
                    'price' => fake()->randomFloat(2, 5, 50),
                    'is_base' =>  false,
                ]);
            }
        });

    }
}
