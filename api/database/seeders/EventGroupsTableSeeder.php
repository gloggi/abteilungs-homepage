<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('event_groups')->delete();
        
        \DB::table('event_groups')->insert(array (
            0 => 
            array (
                'id' => 3,
                'event_id' => 1,
                'group_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 4,
                'event_id' => 1,
                'group_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 5,
                'event_id' => 2,
                'group_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}