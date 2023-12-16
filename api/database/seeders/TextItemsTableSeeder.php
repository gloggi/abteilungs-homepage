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
                'body' => '<p class="main-text">Welcome to the official website of Scout Division Lagom, your gateway to an exciting scouting journey! We are thrilled to share with you a treasure trove of information and hope you find everything you\'re seeking.</p><p class="main-text">Ever wondered how to join the thrilling world of scouting? Delve into our \'About Us\' page to uncover our story, our heritage, and the various levels we offer that make scouting an adventure for everyone. Keen to understand more about the scouting spirit? The \'What is Scouts\' page is your perfect starting point.</p><p class="main-text">Stay in the loop with our \'Current Events\' page, where we regularly update you on exciting activities and events planned for this quarter. Yearning for more? Our annual plan and the enthralling newsletter of our Scout Division, \'The Explorer\'s Digest\', await you in the Downloads section.</p><p class="main-text">And remember, if your journey through our website leaves any stones unturned, our FAQ section is always open to guide you and answer your curiosities. Welcome aboard, and let\'s embark on this remarkable scouting adventure together!</p>',
                'sort' => 0,
                'page_id' => 1,
                'created_at' => '2023-12-15 19:39:56',
                'updated_at' => '2023-12-15 19:42:46',
            ),
        ));
        
        
    }
}