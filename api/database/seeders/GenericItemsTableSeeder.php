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
                'sort' => 1,
                'page_id' => 2,
                'created_at' => '2023-12-15 19:44:11',
                'updated_at' => '2023-12-16 19:51:51',
            ),
            1 => 
            array (
                'id' => 4,
                'type' => 'contactItem',
                'sort' => 2,
                'page_id' => 2,
                'created_at' => '2023-12-15 19:44:11',
                'updated_at' => '2023-12-16 19:51:51',
            ),
            2 => 
            array (
                'id' => 5,
                'type' => 'groupsItem',
                'sort' => 0,
                'page_id' => 2,
                'created_at' => '2023-12-16 19:51:51',
                'updated_at' => '2023-12-16 19:51:51',
            ),
        ));
        
        
    }
}