<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountryCitySeeder::class,
            AirportsSeeder::class,

            HotelsSeeder::class,
            RoomTypeSeeder::class,
            NutritionSeeder::class,
            HotelFeaturesSeeder::class,
            HotelReviewsSeeder::class,

            ToursSeeder::class,
            TourDepartureSeeder::class,

            ReviewSeeder::class,
            NewsSeeder::class,
            MoonShineAdminSeeder::class,
        ]);
    }
}
