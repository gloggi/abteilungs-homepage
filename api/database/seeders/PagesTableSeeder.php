<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pages')->delete();
        
        \DB::table('pages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Home',
                'route' => NULL,
                'big_header' => 0,
                'created_at' => '2023-12-15 17:05:11',
                'updated_at' => '2023-12-15 17:05:11',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'About us',
                'route' => 'about-us',
                'big_header' => 0,
                'created_at' => '2023-12-15 19:44:11',
                'updated_at' => '2023-12-15 19:44:11',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Contact',
                'route' => 'contact',
                'big_header' => 0,
                'created_at' => '2023-12-15 19:44:31',
                'updated_at' => '2023-12-15 19:44:31',
            ),
        ));
        
        
    }
}