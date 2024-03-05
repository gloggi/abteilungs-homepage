<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FormItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('form_items')->delete();
        
        \DB::table('form_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'form_id' => 1,
                'sort' => 1,
                'page_id' => 3,
                'created_at' => '2024-03-05 17:14:55',
                'updated_at' => '2024-03-05 17:14:59',
            ),
            1 => 
            array (
                'id' => 2,
                'form_id' => NULL,
                'sort' => 0,
                'page_id' => 7,
                'created_at' => '2024-03-05 19:34:37',
                'updated_at' => '2024-03-05 19:34:37',
            ),
        ));
        
        
    }
}