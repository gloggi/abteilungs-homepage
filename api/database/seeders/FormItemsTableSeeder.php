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
                'sort' => 0,
                'page_id' => 3,
                'created_at' => '2023-12-15 19:46:44',
                'updated_at' => '2023-12-15 19:47:24',
            ),
        ));
        
        
    }
}