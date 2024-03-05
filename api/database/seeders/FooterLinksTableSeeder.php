<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FooterLinksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('footer_links')->delete();
        
        \DB::table('footer_links')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Pfadihemd kaufen',
                'url' => 'https://www.hajk.ch/de/',
                'sort' => 0,
                'created_at' => '2024-03-05 19:38:03',
                'updated_at' => '2024-03-05 19:38:03',
            ),
        ));
        
        
    }
}