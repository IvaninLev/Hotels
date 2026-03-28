<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    public function run()
    {
        Hotel::all()->each(function ($hotel) {
            $rooms = RoomType::factory()
                ->count(3)
                ->create([
                    'hotel_id' => $hotel->id,
                ]);
            $rooms->first()?->update(['is_base' => true]);
        });
    }
}
