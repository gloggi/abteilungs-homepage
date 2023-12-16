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
                'page_id' => 1,
                'sort' => 0,
                'created_at' => '2023-12-15 20:07:51',
                'updated_at' => '2023-12-15 20:07:51',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => NULL,
                'url' => NULL,
                'page_id' => 2,
                'sort' => 1,
                'created_at' => '2023-12-15 20:07:55',
                'updated_at' => '2023-12-15 20:07:55',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => NULL,
                'url' => NULL,
                'page_id' => 3,
                'sort' => 2,
                'created_at' => '2023-12-15 20:07:58',
                'updated_at' => '2023-12-15 20:07:58',
            ),
        ));
        
        
    }
}