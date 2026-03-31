<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class HotelsSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::factory()->count(100)->create();

    }
}
