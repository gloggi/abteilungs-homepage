<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Biberstufe',
                'from_age' => 4,
                'to_age' => 5,
                'created_at' => '2023-12-11 12:32:21',
                'updated_at' => '2023-12-11 12:32:33',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Wolfsstufe',
                'from_age' => 6,
                'to_age' => 10,
                'created_at' => '2023-12-11 12:32:40',
                'updated_at' => '2023-12-11 12:32:51',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Pfadistufe',
                'from_age' => 11,
                'to_age' => 14,
                'created_at' => '2023-12-11 12:32:55',
                'updated_at' => '2023-12-11 12:33:07',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Piostufe',
                'from_age' => 15,
                'to_age' => 16,
                'created_at' => '2023-12-11 12:33:10',
                'updated_at' => '2023-12-11 12:33:22',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Roverstufe',
                'from_age' => 17,
                'to_age' => 99,
                'created_at' => '2023-12-11 12:33:29',
                'updated_at' => '2023-12-11 12:33:44',
            ),
        ));
        
        
    }
}