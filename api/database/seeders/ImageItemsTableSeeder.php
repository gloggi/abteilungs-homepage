<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImageItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('image_items')->delete();
        
        \DB::table('image_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sort' => 1,
                'page_id' => 1,
                'created_at' => '2023-12-15 19:42:59',
                'updated_at' => '2023-12-15 19:42:59',
            ),
            1 => 
            array (
                'id' => 2,
                'sort' => 1,
                'page_id' => 3,
                'created_at' => '2023-12-15 19:47:34',
                'updated_at' => '2023-12-15 19:47:34',
            ),
        ));
        
        
    }
}