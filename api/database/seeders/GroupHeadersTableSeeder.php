<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupHeadersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('group_headers')->delete();
        
        \DB::table('group_headers')->insert(array (
            0 => 
            array (
                'group_id' => 1,
                'file_id' => 54,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}