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
        
        \DB::table('contacts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'firstname' => 'Luca',
                'lastname' => 'Rossi',
                'nickname' => 'Rabli',
                'email' => 'rabli@pfadi-lagom.ch',
                'role' => 'Biberstufenleiter',
                'file_id' => 32,
                'sort' => 2.0,
                'created_at' => '2023-12-11 13:29:31',
                'updated_at' => '2023-12-21 22:16:41',
            ),
            1 => 
            array (
                'id' => 2,
                'firstname' => 'Sophie',
                'lastname' => 'Müller',
                'nickname' => 'Ferix',
                'email' => 'ferix@pfadi-lagom.ch',
                'role' => 'Wolfsstufenleiterin',
                'file_id' => 31,
                'sort' => 3.0,
                'created_at' => '2023-12-11 13:30:37',
                'updated_at' => '2023-12-21 22:16:53',
            ),
            2 => 
            array (
                'id' => 4,
                'firstname' => 'Raj',
                'lastname' => 'Patel',
                'nickname' => 'Pläsche',
                'email' => 'plaesche@pfadi-lagom.ch',
                'role' => 'Pfadistufenleiter',
                'file_id' => 34,
                'sort' => 4.0,
                'created_at' => '2023-12-11 13:32:14',
                'updated_at' => '2023-12-21 22:17:02',
            ),
            3 => 
            array (
                'id' => 5,
                'firstname' => 'Anna',
                'lastname' => 'Zimmermann',
                'nickname' => 'Wisha',
                'email' => 'wisha@pfadi-lagom.ch',
                'role' => 'Piostufenleiterin',
                'file_id' => 33,
                'sort' => 5.0,
                'created_at' => '2023-12-11 13:33:12',
                'updated_at' => '2023-12-21 22:17:12',
            ),
            4 => 
            array (
                'id' => 6,
                'firstname' => 'Lara',
                'lastname' => 'Ngombo',
                'nickname' => 'Kaya',
                'email' => 'kaya@pfadi-lagom.ch',
                'role' => 'Roverstufenleiterin',
                'file_id' => 38,
                'sort' => 6.0,
                'created_at' => '2023-12-11 13:33:53',
                'updated_at' => '2023-12-21 22:17:19',
            ),
            5 => 
            array (
                'id' => 7,
                'firstname' => 'Marco',
                'lastname' => 'Steiner',
                'nickname' => 'Zusi',
                'email' => 'zusi@pfadi-lagom.ch',
                'role' => 'Abteilungsleiter',
                'file_id' => 35,
                'sort' => 1.2,
                'created_at' => '2023-12-11 13:35:28',
                'updated_at' => '2023-12-21 22:15:47',
            ),
            6 => 
            array (
                'id' => 8,
                'firstname' => 'Mia',
                'lastname' => 'Bianchi',
                'nickname' => 'Rissi',
                'email' => 'rissi@pfadi-lagom.ch',
                'role' => 'Abteilungsleiterin',
                'file_id' => 39,
                'sort' => 1.1,
                'created_at' => '2023-12-11 13:37:03',
                'updated_at' => '2023-12-21 22:15:31',
            ),
        ));
        
        
    }
}