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
        ));
        
        
    }
}