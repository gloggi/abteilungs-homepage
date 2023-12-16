<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Biberstufe',
                'color' => '#9b9292',
                'from_age' => 4,
                'to_age' => 5,
                'file_id' => 44,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:32:21',
                'updated_at' => '2023-12-16 18:47:29',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Wolfsstufe',
                'color' => '#3eb9bb',
                'from_age' => 6,
                'to_age' => 10,
                'file_id' => 43,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:32:40',
                'updated_at' => '2023-12-16 18:47:40',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Pfadistufe',
                'color' => '#cd922d',
                'from_age' => 11,
                'to_age' => 14,
                'file_id' => 42,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:32:55',
                'updated_at' => '2023-12-16 18:47:53',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Piostufe',
                'color' => '#e22828',
                'from_age' => 15,
                'to_age' => 16,
                'file_id' => 41,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:33:10',
                'updated_at' => '2023-12-16 18:48:02',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Roverstufe',
                'color' => NULL,
                'from_age' => 17,
                'to_age' => 99,
                'file_id' => NULL,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:33:29',
                'updated_at' => '2023-12-15 17:04:01',
            ),
        ));
        
        
    }
}