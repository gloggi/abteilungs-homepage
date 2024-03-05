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
                'id' => 11,
                'event_id' => 11,
                'group_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 12,
                'event_id' => 12,
                'group_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 13,
                'event_id' => 13,
                'group_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 14,
                'event_id' => 14,
                'group_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 15,
                'event_id' => 15,
                'group_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 16,
                'event_id' => 16,
                'group_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 19,
                'event_id' => 19,
                'group_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}