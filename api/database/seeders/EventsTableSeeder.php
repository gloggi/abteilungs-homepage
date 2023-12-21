<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('events')->delete();
        
        \DB::table('events')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Testevent',
                'start_time' => '2023-12-24 14:00:00',
                'end_time' => '2023-12-24 17:00:00',
                'start_location_id' => 1,
                'end_location_id' => 1,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>',
                'take_with_you' => '<ul class="list-disc pl-6"><li><p class="main-text">Pfadihemd</p></li><li><p class="main-text">Kravatte</p></li><li><p class="main-text">Ztrinke</p></li></ul>',
                'created_at' => '2023-12-20 21:17:48',
                'updated_at' => '2023-12-20 23:02:10',
            ),
        ));
        
        
    }
}