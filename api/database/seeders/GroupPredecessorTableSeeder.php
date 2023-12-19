<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupPredecessorTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('group_predecessor')->delete();
        
        \DB::table('group_predecessor')->insert(array (
            0 => 
            array (
                'id' => 1,
                'group_id' => 4,
                'predecessor_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'group_id' => 5,
                'predecessor_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}