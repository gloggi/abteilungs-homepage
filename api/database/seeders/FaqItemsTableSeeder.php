<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FaqItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('faq_items')->delete();
        
        \DB::table('faq_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'faq_id' => 1,
                'sort' => 0,
                'page_id' => 5,
                'created_at' => '2024-03-05 17:17:38',
                'updated_at' => '2024-03-05 17:17:48',
            ),
            1 => 
            array (
                'id' => 2,
                'faq_id' => 2,
                'sort' => 1,
                'page_id' => 2,
                'created_at' => '2024-03-05 19:31:15',
                'updated_at' => '2024-03-05 19:31:19',
            ),
        ));
        
        
    }
}