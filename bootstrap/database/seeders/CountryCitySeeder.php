<?php
namespace bootstrap\database\seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class CountryCitySeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/private/worldcities.csv');

        if (!File::exists($path)) {
            echo 'файл не найден ' . $path;
            return;
        }

        $stream = Reader::createFromPath($path);
        $stream->setHeaderOffset(0);

        $rows = iterator_to_array($stream->getRecords());

        $cities = City::pluck('id', 'external_id');

        foreach ($rows as $row) {
            $countryCode = strtoupper($row['iso3'] ?? '');

            if (!$countryCode) {
                continue;
            }

            $country = Country::firstOrCreate([
                'iso_code' => $countryCode,
            ], [
                'name'=>$row['country'],
            ]);

            $cityName = $row['city'] ?? null;
            $cityId = $row['id'] ?? null;
            if(!$cityName || !$cityId){
                continue;
            }
            City::firstOrCreate([
               'external_id'=>$cityId
            ],[
                'name'=>$cityName,
                'country_id'=>$country->id
            ]);
        }
    }
}
