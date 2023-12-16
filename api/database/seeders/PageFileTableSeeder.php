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
                'file_id' => 50,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'page_id' => 2,
                'file_id' => 53,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'page_id' => 3,
                'file_id' => 54,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}