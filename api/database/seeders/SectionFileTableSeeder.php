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
                'file_id' => 51,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}