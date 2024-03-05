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
        
        
        
    }
}