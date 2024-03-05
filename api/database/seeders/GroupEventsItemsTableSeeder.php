<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupEventsItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('group_events_items')->delete();
        
        \DB::table('group_events_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'group_id' => 7,
                'sort' => 3,
                'page_id' => 2,
                'created_at' => '2024-03-05 16:15:29',
                'updated_at' => '2024-03-05 19:31:15',
            ),
            1 => 
            array (
                'id' => 2,
                'group_id' => 1,
                'sort' => 1,
                'page_id' => 6,
                'created_at' => '2024-03-05 19:33:45',
                'updated_at' => '2024-03-05 19:33:50',
            ),
        ));
        
        
    }
}