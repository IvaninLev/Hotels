<?php

namespace Database\Seeders;

use App\Http\Resources\TourDepartureResource;
use Database\Factories\TourReviewFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class   DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            ReviewSeeder::class,
        ];
        $this->call($seeders);
    }

}
