<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TextFieldsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('text_fields')->delete();
        
        \DB::table('text_fields')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => 'Vorname',
                'input_type' => 'text',
                'required' => 1,
                'sort' => 0,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:07:37',
                'updated_at' => '2024-03-05 17:07:49',
            ),
            1 => 
            array (
                'id' => 2,
                'label' => 'Nachname',
                'input_type' => 'text',
                'required' => 1,
                'sort' => 1,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:07:49',
                'updated_at' => '2024-03-05 17:08:09',
            ),
            2 => 
            array (
                'id' => 3,
                'label' => 'E-Mail',
                'input_type' => 'email',
                'required' => 1,
                'sort' => 2,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:08:09',
                'updated_at' => '2024-03-05 17:08:20',
            ),
            3 => 
            array (
                'id' => 4,
                'label' => 'Geburtstag',
                'input_type' => 'date',
                'required' => 0,
                'sort' => 3,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:08:20',
                'updated_at' => '2024-03-05 17:08:37',
            ),
            4 => 
            array (
                'id' => 5,
                'label' => 'Geschwister',
                'input_type' => 'time',
                'required' => 0,
                'sort' => 4,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:08:37',
                'updated_at' => '2024-03-05 17:08:59',
            ),
            5 => 
            array (
                'id' => 6,
                'label' => 'Lieblingsuhrzeit',
                'input_type' => 'time',
                'required' => 0,
                'sort' => 5,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:08:59',
                'updated_at' => '2024-03-05 17:09:08',
            ),
            6 => 
            array (
                'id' => 7,
                'label' => 'Pfadiname',
                'input_type' => 'text',
                'required' => 1,
                'sort' => 0,
                'form_id' => 2,
                'created_at' => '2024-03-05 19:36:48',
                'updated_at' => '2024-03-05 19:37:01',
            ),
        ));
        
        
    }
}