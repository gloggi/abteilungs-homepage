<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FilesItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('files_items')->delete();
        
        
        
    }
}