<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('location_items')->delete();
        
        \DB::table('location_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'location_id' => 2,
                'sort' => 1,
                'page_id' => 9,
                'created_at' => '2024-03-11 20:30:21',
                'updated_at' => '2024-03-11 20:30:21',
            ),
        ));
        
        
    }
}