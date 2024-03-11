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
                'id' => 1,
                'type' => 'groupsItem',
                'sort' => 0,
                'page_id' => 4,
                'created_at' => '2024-03-05 17:16:39',
                'updated_at' => '2024-03-05 17:16:39',
            ),
            1 => 
            array (
                'id' => 2,
                'type' => 'contactItem',
                'sort' => 1,
                'page_id' => 4,
                'created_at' => '2024-03-05 17:16:39',
                'updated_at' => '2024-03-05 17:16:39',
            ),
            2 => 
            array (
                'id' => 3,
                'type' => 'sectionsItem',
                'sort' => 2,
                'page_id' => 4,
                'created_at' => '2024-03-05 17:16:39',
                'updated_at' => '2024-03-05 17:16:39',
            ),
            3 => 
            array (
                'id' => 4,
                'type' => 'campsItem',
                'sort' => 3,
                'page_id' => 1,
                'created_at' => '2024-03-11 20:28:32',
                'updated_at' => '2024-03-11 20:28:32',
            ),
        ));
        
        
    }
}