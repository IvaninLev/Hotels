<?php

namespace bootstrap\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            CountryCitySeeder::class
        ];
        if(App::isLocal()){
            $seeders = array_merge([],$seeders);
        }
        $this->call($seeders);
    }
}
