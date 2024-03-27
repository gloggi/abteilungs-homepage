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

        \DB::table('sections')->insert([
            0 => [
                'id' => 1,
                'name' => 'Biberstufe',
                'color' => '#9b9292',
                'from_age' => 4,
                'to_age' => 5,
                'file_id' => 10,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:32:21',
                'updated_at' => '2024-03-05 15:20:37',
            ],
            1 => [
                'id' => 2,
                'name' => 'Wolfsstufe',
                'color' => '#3eb9bb',
                'from_age' => 6,
                'to_age' => 10,
                'file_id' => 11,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:32:40',
                'updated_at' => '2024-03-05 15:20:57',
            ],
            2 => [
                'id' => 3,
                'name' => 'Pfadistufe',
                'color' => '#cd922d',
                'from_age' => 11,
                'to_age' => 14,
                'file_id' => 12,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:32:55',
                'updated_at' => '2024-03-05 15:21:22',
            ],
            3 => [
                'id' => 4,
                'name' => 'Piostufe',
                'color' => '#e22828',
                'from_age' => 15,
                'to_age' => 16,
                'file_id' => 13,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:33:10',
                'updated_at' => '2024-03-05 15:21:35',
            ],
            4 => [
                'id' => 5,
                'name' => 'Roverstufe',
                'color' => '#595959',
                'from_age' => 17,
                'to_age' => 99,
                'file_id' => null,
                'description' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'created_at' => '2023-12-11 12:33:29',
                'updated_at' => '2023-12-16 22:41:50',
            ],
        ]);

    }
}
