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
                'label' => 'Firstname',
                'input_type' => 'text',
                'required' => 1,
                'sort' => 0,
                'form_id' => 1,
                'created_at' => '2023-12-15 20:05:18',
                'updated_at' => '2023-12-15 20:05:26',
            ),
            1 => 
            array (
                'id' => 2,
                'label' => 'Lastname',
                'input_type' => 'text',
                'required' => 1,
                'sort' => 1,
                'form_id' => 1,
                'created_at' => '2023-12-15 20:05:26',
                'updated_at' => '2023-12-15 20:05:32',
            ),
            2 => 
            array (
                'id' => 3,
                'label' => 'E-Mail',
                'input_type' => 'email',
                'required' => 1,
                'sort' => 2,
                'form_id' => 1,
                'created_at' => '2023-12-15 20:05:32',
                'updated_at' => '2023-12-15 20:05:39',
            ),
            3 => 
            array (
                'id' => 4,
                'label' => 'Date of Birth',
                'input_type' => 'date',
                'required' => 0,
                'sort' => 3,
                'form_id' => 1,
                'created_at' => '2023-12-15 20:05:39',
                'updated_at' => '2023-12-15 20:05:45',
            ),
            4 => 
            array (
                'id' => 5,
                'label' => 'Message',
                'input_type' => 'text',
                'required' => 1,
                'sort' => 4,
                'form_id' => 1,
                'created_at' => '2023-12-15 20:05:45',
                'updated_at' => '2023-12-15 20:05:52',
            ),
        ));
        
        
    }
}