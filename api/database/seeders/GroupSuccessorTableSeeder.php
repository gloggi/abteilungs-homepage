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
        ));
        
        
    }
}