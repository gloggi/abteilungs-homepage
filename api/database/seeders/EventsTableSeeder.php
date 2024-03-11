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
                'id' => 11,
                'title' => 'Aktivität',
                'start_time' => '2024-03-23 14:00:00',
                'end_time' => '2024-03-23 16:00:00',
                'start_location_id' => 3,
                'end_location_id' => 3,
                'description' => '<p class="main-text">Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p>',
                'take_with_you' => '<ul class="list-disc pl-6"><li><p class="main-text">Pfadihemd</p></li><li><p class="main-text">Pfadikravatte</p></li><li><p class="main-text">gute Schuhe</p></li><li><p class="main-text">Ztrinke</p></li></ul>',
                'midata_id' => 2215,
                'external_application_link' => 'https://pbs.puzzle.ch/de/groups/1503/public_events/2215',
                'user_id' => NULL,
                'created_at' => '2024-03-05 16:11:11',
                'updated_at' => '2024-03-05 16:14:23',
            ),
            1 => 
            array (
                'id' => 12,
                'title' => 'Aktivität',
                'start_time' => '2024-03-30 14:00:00',
                'end_time' => '2024-03-30 16:00:00',
                'start_location_id' => 1,
                'end_location_id' => 1,
                'description' => NULL,
                'take_with_you' => '<ul class="list-disc pl-6"><li><p class="main-text">Pfadihemd</p></li><li><p class="main-text">Pfadikravatte</p></li><li><p class="main-text">gute Schuhe</p></li><li><p class="main-text">Ztrinke</p></li></ul>',
                'midata_id' => 2216,
                'external_application_link' => 'https://pbs.puzzle.ch/de/groups/1503/public_events/2216',
                'user_id' => NULL,
                'created_at' => '2024-03-05 16:11:11',
                'updated_at' => '2024-03-05 16:14:28',
            ),
            2 => 
            array (
                'id' => 13,
                'title' => 'Aktivität',
                'start_time' => '2024-04-06 14:00:00',
                'end_time' => '2024-04-06 16:00:00',
                'start_location_id' => 2,
                'end_location_id' => 2,
                'description' => NULL,
                'take_with_you' => NULL,
                'midata_id' => 2217,
                'external_application_link' => 'https://pbs.puzzle.ch/de/groups/1503/public_events/2217',
                'user_id' => NULL,
                'created_at' => '2024-03-05 16:11:11',
                'updated_at' => '2024-03-05 16:11:11',
            ),
            3 => 
            array (
                'id' => 14,
                'title' => 'Aktivität',
                'start_time' => '2024-04-13 14:00:00',
                'end_time' => '2024-04-13 16:00:00',
                'start_location_id' => 1,
                'end_location_id' => 1,
                'description' => NULL,
                'take_with_you' => NULL,
                'midata_id' => 2218,
                'external_application_link' => 'https://pbs.puzzle.ch/de/groups/1503/public_events/2218',
                'user_id' => NULL,
                'created_at' => '2024-03-05 16:11:11',
                'updated_at' => '2024-03-05 16:11:11',
            ),
            4 => 
            array (
                'id' => 15,
                'title' => 'Aktivität',
                'start_time' => '2024-04-20 14:00:00',
                'end_time' => '2024-04-20 16:00:00',
                'start_location_id' => 3,
                'end_location_id' => 3,
                'description' => NULL,
                'take_with_you' => NULL,
                'midata_id' => 2219,
                'external_application_link' => 'https://pbs.puzzle.ch/de/groups/1503/public_events/2219',
                'user_id' => NULL,
                'created_at' => '2024-03-05 16:11:11',
                'updated_at' => '2024-03-05 16:11:11',
            ),
            5 => 
            array (
                'id' => 16,
                'title' => 'Aktivität',
                'start_time' => '2024-05-17 14:00:00',
                'end_time' => '2024-05-17 16:00:00',
                'start_location_id' => 3,
                'end_location_id' => 3,
                'description' => NULL,
                'take_with_you' => NULL,
                'midata_id' => 2220,
                'external_application_link' => 'https://pbs.puzzle.ch/de/groups/1503/public_events/2220',
                'user_id' => NULL,
                'created_at' => '2024-03-05 16:11:11',
                'updated_at' => '2024-03-05 16:11:11',
            ),
            6 => 
            array (
                'id' => 19,
                'title' => 'Testaktivität',
                'start_time' => '2024-03-16 14:00:00',
                'end_time' => '2024-03-16 17:00:00',
                'start_location_id' => 2,
                'end_location_id' => 1,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p>',
                'take_with_you' => '<ul class="list-disc pl-6"><li><p class="main-text">Pfadihemd</p></li><li><p class="main-text">Pfadikravatte</p></li><li><p class="main-text">gute Schuhe</p></li><li><p class="main-text">Ztrinke</p></li></ul>',
                'midata_id' => NULL,
                'external_application_link' => NULL,
                'user_id' => NULL,
                'created_at' => '2024-03-05 16:13:40',
                'updated_at' => '2024-03-05 16:13:40',
            ),
        ));
        
        
    }
}