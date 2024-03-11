<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PageFileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('page_file')->delete();
        
        \DB::table('page_file')->insert(array (
            0 => 
            array (
                'page_id' => 1,
                'file_id' => 28,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'page_id' => 1,
                'file_id' => 35,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'page_id' => 1,
                'file_id' => 27,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'page_id' => 2,
                'file_id' => 29,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'page_id' => 3,
                'file_id' => 23,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'page_id' => 4,
                'file_id' => 30,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'page_id' => 5,
                'file_id' => 31,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'page_id' => 6,
                'file_id' => 34,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'page_id' => 7,
                'file_id' => 33,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'page_id' => 9,
                'file_id' => 31,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}