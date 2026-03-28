<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\HotelFeature;
use Illuminate\Database\Seeder;

class HotelFeaturesSeeder extends Seeder
{
    public function run()
    {
        Hotel::all()->each(function ($hotel) {
            HotelFeature::factory()->count(rand(1, 5))->create([
                'hotel_id' => $hotel->id,
            ]);
        });
    }
}

