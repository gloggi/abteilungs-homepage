<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionFileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('section_file')->delete();
        
        \DB::table('section_file')->insert(array (
            0 => 
            array (
                'section_id' => 1,
                'file_id' => 27,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'section_id' => 2,
                'file_id' => 31,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'section_id' => 2,
                'file_id' => 32,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'section_id' => 3,
                'file_id' => 24,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'section_id' => 4,
                'file_id' => 33,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'section_id' => 5,
                'file_id' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}