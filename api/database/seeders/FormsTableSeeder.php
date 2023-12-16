<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FormsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('forms')->delete();
        
        \DB::table('forms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Contact',
                'email' => 'contact@pfadi-lagom.ch',
                'subject' => 'Contact',
                'message' => NULL,
                'created_at' => '2023-12-15 20:02:15',
                'updated_at' => '2023-12-15 20:05:13',
            ),
        ));
        
        
    }
}