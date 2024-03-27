<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('pages')->delete();

        \DB::table('pages')->insert([
            0 => [
                'id' => 1,
                'group_id' => null,
                'title' => 'Home',
                'route' => null,
                'big_header' => 1,
                'created_at' => '2024-03-05 14:44:38',
                'updated_at' => '2024-03-05 17:27:29',
            ],
            1 => [
                'id' => 2,
                'group_id' => 7,
                'title' => 'Whales',
                'route' => 'whales',
                'big_header' => 0,
                'created_at' => '2024-03-05 16:15:16',
                'updated_at' => '2024-03-05 16:15:16',
            ],
            2 => [
                'id' => 3,
                'group_id' => null,
                'title' => 'Kontakt',
                'route' => 'kontakt',
                'big_header' => 0,
                'created_at' => '2024-03-05 17:13:33',
                'updated_at' => '2024-03-05 17:13:33',
            ],
            3 => [
                'id' => 4,
                'group_id' => null,
                'title' => 'Über uns',
                'route' => 'uber-uns',
                'big_header' => 0,
                'created_at' => '2024-03-05 17:16:39',
                'updated_at' => '2024-03-05 17:16:39',
            ],
            4 => [
                'id' => 5,
                'group_id' => null,
                'title' => 'Fragen',
                'route' => 'faq',
                'big_header' => 0,
                'created_at' => '2024-03-05 17:17:38',
                'updated_at' => '2024-03-05 17:17:38',
            ],
            5 => [
                'id' => 6,
                'group_id' => 1,
                'title' => 'Bears',
                'route' => 'bears',
                'big_header' => 0,
                'created_at' => '2024-03-05 19:33:11',
                'updated_at' => '2024-03-05 19:33:11',
            ],
            6 => [
                'id' => 7,
                'group_id' => 9,
                'title' => 'Owls',
                'route' => 'owls',
                'big_header' => 0,
                'created_at' => '2024-03-05 19:34:37',
                'updated_at' => '2024-03-05 19:34:37',
            ],
            7 => [
                'id' => 8,
                'group_id' => null,
                'title' => '404',
                'route' => '404',
                'big_header' => 0,
                'created_at' => '2024-03-05 19:42:26',
                'updated_at' => '2024-03-05 19:42:26',
            ],
            8 => [
                'id' => 9,
                'group_id' => null,
                'title' => 'Schnuppertag',
                'route' => 'schnuppertag',
                'big_header' => 0,
                'created_at' => '2024-03-11 20:30:21',
                'updated_at' => '2024-03-11 20:30:21',
            ],
        ]);

    }
}
