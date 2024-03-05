<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TextareaFieldsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('textarea_fields')->delete();
        
        \DB::table('textarea_fields')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => 'Nachricht',
                'required' => 1,
                'sort' => 6,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:09:08',
                'updated_at' => '2024-03-05 17:09:21',
            ),
            1 => 
            array (
                'id' => 2,
                'label' => 'Nachricht',
                'required' => 1,
                'sort' => 1,
                'form_id' => 2,
                'created_at' => '2024-03-05 19:37:01',
                'updated_at' => '2024-03-05 19:37:08',
            ),
        ));
        
        
    }
}