<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GenericItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('generic_items')->delete();
        
        \DB::table('generic_items')->insert(array (
            0 => 
            array (
                'id' => 3,
                'type' => 'sectionsItem',
                'sort' => 0,
                'page_id' => 2,
                'created_at' => '2023-12-15 19:44:11',
                'updated_at' => '2023-12-15 19:44:11',
            ),
            1 => 
            array (
                'id' => 4,
                'type' => 'contactItem',
                'sort' => 1,
                'page_id' => 2,
                'created_at' => '2023-12-15 19:44:11',
                'updated_at' => '2023-12-15 19:44:11',
            ),
        ));
        
        
    }
}