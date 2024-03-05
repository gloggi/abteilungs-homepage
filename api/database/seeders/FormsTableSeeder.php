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
                'group_id' => NULL,
                'name' => 'Kontakt',
                'email' => 'kantakt@pfadi-lagom.ch',
                'subject' => 'Kontaktformular',
                'message' => NULL,
                'created_at' => '2024-03-05 17:06:07',
                'updated_at' => '2024-03-05 17:06:07',
            ),
            1 => 
            array (
                'id' => 2,
                'group_id' => 9,
                'name' => 'Gruppenformular',
                'email' => 'owls@pfadi-lagom.ch',
                'subject' => 'Neue Antwort',
                'message' => NULL,
                'created_at' => '2024-03-05 19:36:02',
                'updated_at' => '2024-03-05 19:36:39',
            ),
        ));
        
        
    }
}