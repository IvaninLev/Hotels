<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\HotelReview;
use Illuminate\Database\Seeder;

class HotelReviewsSeeder extends Seeder
{
    public function run()
    {
        Hotel::all()->each(function ($hotel) {
            HotelReview::factory()
                ->count(200)
                ->create([
                    'hotel_id' => $hotel->id,
                ]);
        });
    }
}
