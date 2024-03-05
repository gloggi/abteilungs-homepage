<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupSuccessorTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('group_successor')->delete();
        
        \DB::table('group_successor')->insert(array (
            0 => 
            array (
                'id' => 1,
                'group_id' => 1,
                'successor_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'group_id' => 1,
                'successor_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'group_id' => 4,
                'successor_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'group_id' => 4,
                'successor_id' => 10,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'group_id' => 4,
                'successor_id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'group_id' => 5,
                'successor_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'group_id' => 6,
                'successor_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'group_id' => 8,
                'successor_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}