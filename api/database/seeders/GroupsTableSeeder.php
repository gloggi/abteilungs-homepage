<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('groups')->delete();

        \DB::table('groups')->insert([
            0 => [
                'id' => 1,
                'name' => 'Bears',
                'color' => '#f49f9f',
                'contact' => null,
                'region' => 'Kvarnvik, Snajdiga & Brusali',
                'gender' => 1,
                'midata_id' => null,
                'parent_id' => null,
                'section_id' => 1,
                'file_id' => 14,
                'created_at' => '2023-12-11 13:00:24',
                'updated_at' => '2024-03-05 15:57:39',
            ],
            1 => [
                'id' => 4,
                'name' => 'Camels',
                'color' => '#73e8d1',
                'contact' => null,
                'region' => 'Kvarnvik, Snajdiga & Brusali',
                'gender' => 3,
                'midata_id' => null,
                'parent_id' => null,
                'section_id' => 2,
                'file_id' => 15,
                'created_at' => '2023-12-11 13:04:00',
                'updated_at' => '2024-03-05 15:58:52',
            ],
            2 => [
                'id' => 5,
                'name' => 'Snakes',
                'color' => '#7599e1',
                'contact' => null,
                'region' => 'Kvarnvik, Snajdiga & Brusali',
                'gender' => 2,
                'midata_id' => 1526,
                'parent_id' => null,
                'section_id' => 2,
                'file_id' => 16,
                'created_at' => '2023-12-11 13:04:44',
                'updated_at' => '2024-03-05 15:58:57',
            ],
            3 => [
                'id' => 6,
                'name' => 'Giraffes',
                'color' => '#ca7aff',
                'contact' => null,
                'region' => 'Kvarnvik, Snajdiga & Brusali',
                'gender' => 1,
                'midata_id' => 1517,
                'parent_id' => null,
                'section_id' => 3,
                'file_id' => 17,
                'created_at' => '2023-12-11 13:19:05',
                'updated_at' => '2024-03-05 15:59:06',
            ],
            4 => [
                'id' => 7,
                'name' => 'Whales',
                'color' => '#e0d452',
                'contact' => null,
                'region' => 'Kvarnvik, Snajdiga & Brusali',
                'gender' => 1,
                'midata_id' => 1503,
                'parent_id' => null,
                'section_id' => 3,
                'file_id' => 18,
                'created_at' => '2023-12-11 13:19:38',
                'updated_at' => '2024-03-05 15:59:10',
            ],
            5 => [
                'id' => 8,
                'name' => 'Pandas',
                'color' => '#ff5252',
                'contact' => null,
                'region' => 'Kvarnvik, Snajdiga & Brusali',
                'gender' => 1,
                'midata_id' => null,
                'parent_id' => null,
                'section_id' => 4,
                'file_id' => 19,
                'created_at' => '2023-12-11 13:20:21',
                'updated_at' => '2024-03-05 15:58:31',
            ],
            6 => [
                'id' => 9,
                'name' => 'Owls',
                'color' => '#696969',
                'contact' => null,
                'region' => 'Kvarnvik, Snajdiga & Brusali',
                'gender' => 1,
                'midata_id' => null,
                'parent_id' => null,
                'section_id' => 5,
                'file_id' => 20,
                'created_at' => '2023-12-11 13:21:05',
                'updated_at' => '2024-03-05 15:58:25',
            ],
            7 => [
                'id' => 10,
                'name' => 'Koalas',
                'color' => '#ec8e8e',
                'contact' => null,
                'region' => 'Snajdiga & Brusali',
                'gender' => 3,
                'midata_id' => null,
                'parent_id' => 6,
                'section_id' => 3,
                'file_id' => 21,
                'created_at' => '2024-03-05 15:49:44',
                'updated_at' => '2024-03-05 15:59:21',
            ],
            8 => [
                'id' => 11,
                'name' => 'Monkeys',
                'color' => '#7e4444',
                'contact' => null,
                'region' => 'Kvarnvik',
                'gender' => 3,
                'midata_id' => null,
                'parent_id' => 6,
                'section_id' => 3,
                'file_id' => 22,
                'created_at' => '2024-03-05 15:51:41',
                'updated_at' => '2024-03-05 15:59:48',
            ],
        ]);

    }
}
