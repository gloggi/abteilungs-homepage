<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_items')->delete();
        
        \DB::table('menu_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => NULL,
                'url' => NULL,
                'special' => NULL,
                'page_id' => 1,
                'sort' => 0,
                'created_at' => '2024-03-05 16:00:27',
                'updated_at' => '2024-03-05 16:00:27',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Group Dropdown',
                'url' => NULL,
                'special' => 'groupPages',
                'page_id' => NULL,
                'sort' => 5,
                'created_at' => '2024-03-05 16:16:52',
                'updated_at' => '2024-03-05 17:18:33',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Gloggi',
                'url' => 'https://gloggi.ch',
                'special' => NULL,
                'page_id' => NULL,
                'sort' => 4,
                'created_at' => '2024-03-05 17:15:51',
                'updated_at' => '2024-03-05 17:18:33',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => NULL,
                'url' => NULL,
                'special' => NULL,
                'page_id' => 3,
                'sort' => 1,
                'created_at' => '2024-03-05 17:15:55',
                'updated_at' => '2024-03-05 17:15:55',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => NULL,
                'url' => NULL,
                'special' => NULL,
                'page_id' => 4,
                'sort' => 2,
                'created_at' => '2024-03-05 17:18:31',
                'updated_at' => '2024-03-05 17:18:31',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => NULL,
                'url' => NULL,
                'special' => NULL,
                'page_id' => 5,
                'sort' => 3,
                'created_at' => '2024-03-05 17:18:33',
                'updated_at' => '2024-03-05 17:18:33',
            ),
        ));
        
        
    }
}