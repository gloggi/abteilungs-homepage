<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('locations')->delete();

        \DB::table('locations')->insert([
            0 => [
                'id' => 1,
                'name' => 'Zürich HB',
                'lat' => '47.377862',
                'long' => '8.540297',
                'created_at' => '2024-03-05 16:09:14',
                'updated_at' => '2024-03-05 16:09:14',
            ],
            1 => [
                'id' => 2,
                'name' => 'Bahnhof Schwerzenbach',
                'lat' => '47.384589',
                'long' => '8.658706',
                'created_at' => '2024-03-05 16:09:50',
                'updated_at' => '2024-03-05 16:09:50',
            ],
            2 => [
                'id' => 3,
                'name' => 'Bellevue',
                'lat' => '47.366767',
                'long' => '8.545087',
                'created_at' => '2024-03-05 16:10:30',
                'updated_at' => '2024-03-05 16:10:30',
            ],
        ]);

    }
}
