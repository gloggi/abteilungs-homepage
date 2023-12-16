<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SelectFieldsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('select_fields')->delete();
        
        
        
    }
}