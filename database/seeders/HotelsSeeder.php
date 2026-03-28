<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class HotelsSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::factory()->count(10)->create();

        $sourcePath = database_path('storage/app/public/hotels');

        $targetPath = 'hotels';

        Storage::disk('public')->makeDirectory($targetPath);

        $files = [
            'hotel_1.jpg',
            'hotel_2.jpg',
            'hotel_3.jpg',
        ];

        foreach ($files as $file) {
            $src = $sourcePath . '/' . $file;
            if (is_file($src)) {
                Storage::disk('public')->put(
                    $targetPath . '/' . $file,
                    file_get_contents($src)
                );
            }
        }
    }
}
