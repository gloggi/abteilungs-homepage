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
        
        \DB::table('locations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Zürich HB',
                'lat' => 47.378621816357,
                'long' => 8.5374690413412,
                'created_at' => '2023-12-20 21:16:48',
                'updated_at' => '2023-12-20 21:16:48',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Bellevue',
                'lat' => 47.366928324186,
                'long' => 8.5447274514975,
                'created_at' => '2023-12-22 20:24:17',
                'updated_at' => '2023-12-22 20:24:17',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Bahnhof Schwerzenbach',
                'lat' => 47.384163916735,
                'long' => 8.6593313026431,
                'created_at' => '2023-12-22 20:27:42',
                'updated_at' => '2023-12-22 20:27:42',
            ),
        ));
        
        
    }
}