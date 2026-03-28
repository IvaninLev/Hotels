<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;

class ToursSeeder extends Seeder
{
    public function run(): void
    {
        Tour::factory()->count(15)->create();
    }
}
