<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImageItemFileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('image_item_file')->delete();
        
        \DB::table('image_item_file')->insert(array (
            0 => 
            array (
                'image_item_id' => 1,
                'file_id' => 30,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'image_item_id' => 1,
                'file_id' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'image_item_id' => 1,
                'file_id' => 24,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'image_item_id' => 2,
                'file_id' => 36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'image_item_id' => 2,
                'file_id' => 39,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}