<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourDeparture;
use Illuminate\Database\Seeder;

class TourDepartureSeeder extends Seeder
{
    public function run()
    {
        $tours = Tour::all();

        foreach ($tours as $tour) {
            TourDeparture::factory()
                ->count(rand(3, 5))
                ->create([
                    'tour_id' => $tour->id,
                ]);
        }
    }

}
