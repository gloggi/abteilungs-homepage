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
                'sort' => 0.0,
                'created_at' => '2023-12-11 13:29:31',
                'updated_at' => '2023-12-11 14:32:43',
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
                'sort' => 0.0,
                'created_at' => '2023-12-11 13:30:37',
                'updated_at' => '2023-12-11 14:32:50',
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
                'sort' => 0.0,
                'created_at' => '2023-12-11 13:32:14',
                'updated_at' => '2023-12-11 14:32:59',
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
                'sort' => 0.0,
                'created_at' => '2023-12-11 13:33:12',
                'updated_at' => '2023-12-11 14:33:06',
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
                'sort' => 0.0,
                'created_at' => '2023-12-11 13:33:53',
                'updated_at' => '2023-12-11 18:19:09',
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
                'sort' => 0.0,
                'created_at' => '2023-12-11 13:35:28',
                'updated_at' => '2023-12-11 14:33:17',
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
                'sort' => 0.0,
                'created_at' => '2023-12-11 13:37:03',
                'updated_at' => '2023-12-11 18:20:09',
            ),
        ));
        
        
    }
}