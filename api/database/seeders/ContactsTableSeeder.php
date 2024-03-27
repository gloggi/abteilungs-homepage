<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('contacts')->delete();

        \DB::table('contacts')->insert([
            0 => [
                'id' => 1,
                'firstname' => 'Mia',
                'lastname' => 'Bianchi',
                'nickname' => 'Rissi',
                'email' => 'rissi@pfadi-lagom.ch',
                'role' => 'Abteilungsleiterin',
                'file_id' => 3,
                'sort' => 1.1,
                'created_at' => '2024-03-05 15:09:50',
                'updated_at' => '2024-03-05 15:09:50',
            ],
            1 => [
                'id' => 2,
                'firstname' => 'Marco',
                'lastname' => 'Steiner',
                'nickname' => 'Zusi',
                'email' => 'zusi@pfadi-lagom.ch',
                'role' => 'Abteilungsleiter',
                'file_id' => 4,
                'sort' => 1.2,
                'created_at' => '2024-03-05 15:10:54',
                'updated_at' => '2024-03-05 15:10:54',
            ],
            2 => [
                'id' => 3,
                'firstname' => 'Lara',
                'lastname' => 'Ngombo',
                'nickname' => 'Kaya',
                'email' => 'kaya@pfadi-lagom.ch',
                'role' => 'Roverstufenleiterin',
                'file_id' => 5,
                'sort' => 6.1,
                'created_at' => '2024-03-05 15:12:35',
                'updated_at' => '2024-03-05 15:16:19',
            ],
            3 => [
                'id' => 4,
                'firstname' => 'Anna',
                'lastname' => 'Zimmermann',
                'nickname' => 'Wisha',
                'email' => 'wisha@pfadi-lagom.ch',
                'role' => 'Piostufenleiterin',
                'file_id' => 6,
                'sort' => 5.1,
                'created_at' => '2024-03-05 15:13:36',
                'updated_at' => '2024-03-05 15:16:12',
            ],
            4 => [
                'id' => 5,
                'firstname' => 'Raj',
                'lastname' => 'Patel',
                'nickname' => 'Pläsche',
                'email' => 'plaesche@pfadi-lagom.ch',
                'role' => 'Pfadistufenleiter',
                'file_id' => 7,
                'sort' => 4.1,
                'created_at' => '2024-03-05 15:14:47',
                'updated_at' => '2024-03-05 15:16:02',
            ],
            5 => [
                'id' => 6,
                'firstname' => 'Sophie',
                'lastname' => 'Müller',
                'nickname' => 'Ferix',
                'email' => 'ferix@pfadi-lagom.ch',
                'role' => 'Wolfsstufenleiterin',
                'file_id' => 8,
                'sort' => 3.1,
                'created_at' => '2024-03-05 15:15:28',
                'updated_at' => '2024-03-05 15:15:47',
            ],
            6 => [
                'id' => 7,
                'firstname' => 'Luca',
                'lastname' => 'Rossi',
                'nickname' => 'Rabli',
                'email' => 'rabli@pfadi-lagom.ch',
                'role' => 'Biberstufenleiter',
                'file_id' => 9,
                'sort' => 2.1,
                'created_at' => '2024-03-05 15:17:16',
                'updated_at' => '2024-03-05 15:17:16',
            ],
        ]);

    }
}
