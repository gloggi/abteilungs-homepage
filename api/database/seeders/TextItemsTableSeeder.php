<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TextItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('text_items')->delete();
        
        \DB::table('text_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Welcome to the Website of Pfadi Lagom!',
                'body' => '<p class="main-text">Lorem <span style="color: #f28c8c">ipsum</span> dolor sit amet, consetetur <a target="_blank" rel="noopener noreferrer nofollow" class="link hover:text-secondary" href="/about-us">sadipscing</a> elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'show_fleur_de_lis' => 1,
                'sort' => 0,
                'page_id' => 1,
                'created_at' => '2023-12-15 19:39:56',
                'updated_at' => '2023-12-21 22:40:01',
            ),
        ));
        
        
    }
}