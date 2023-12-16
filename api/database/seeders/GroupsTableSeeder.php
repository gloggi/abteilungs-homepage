<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('groups')->delete();
        
        \DB::table('groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Bears',
                'color' => '#f49f9f',
                'section_id' => 1,
                'file_id' => 1,
                'created_at' => '2023-12-11 13:00:24',
                'updated_at' => '2023-12-16 19:02:07',
            ),
            1 => 
            array (
                'id' => 4,
                'name' => 'Camels',
                'color' => '#73e8d1',
                'section_id' => 2,
                'file_id' => 2,
                'created_at' => '2023-12-11 13:04:00',
                'updated_at' => '2023-12-16 19:02:14',
            ),
            2 => 
            array (
                'id' => 5,
                'name' => 'Snakes',
                'color' => '#7599e1',
                'section_id' => 2,
                'file_id' => 3,
                'created_at' => '2023-12-11 13:04:44',
                'updated_at' => '2023-12-16 19:02:21',
            ),
            3 => 
            array (
                'id' => 6,
                'name' => 'Giraffes',
                'color' => '#ca7aff',
                'section_id' => 3,
                'file_id' => 4,
                'created_at' => '2023-12-11 13:19:05',
                'updated_at' => '2023-12-16 19:02:27',
            ),
            4 => 
            array (
                'id' => 7,
                'name' => 'Whales',
                'color' => '#e0d452',
                'section_id' => 3,
                'file_id' => 5,
                'created_at' => '2023-12-11 13:19:38',
                'updated_at' => '2023-12-16 19:02:40',
            ),
            5 => 
            array (
                'id' => 8,
                'name' => 'Pandas',
                'color' => '#ff5252',
                'section_id' => 4,
                'file_id' => 6,
                'created_at' => '2023-12-11 13:20:21',
                'updated_at' => '2023-12-16 19:02:47',
            ),
            6 => 
            array (
                'id' => 9,
                'name' => 'Owls',
                'color' => '#696969',
                'section_id' => 5,
                'file_id' => 7,
                'created_at' => '2023-12-11 13:21:05',
                'updated_at' => '2023-12-16 19:02:54',
            ),
        ));
        
        
    }
}