<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Location;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $locations = Location::factory()->count(5)->create();

        $locations->each(function (Location $location){
           Equipment::factory()->for($location)->count(10)->create();
        });
    }
}
