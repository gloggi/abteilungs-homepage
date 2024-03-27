<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FormsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('forms')->delete();

        \DB::table('forms')->insert([
            0 => [
                'id' => 1,
                'group_id' => null,
                'name' => 'Kontakt',
                'email' => 'kantakt@pfadi-lagom.ch',
                'subject' => 'Kontaktformular',
                'message' => null,
                'created_at' => '2024-03-05 17:06:07',
                'updated_at' => '2024-03-05 17:06:07',
            ],
            1 => [
                'id' => 2,
                'group_id' => 9,
                'name' => 'Gruppenformular',
                'email' => 'owls@pfadi-lagom.ch',
                'subject' => 'Neue Antwort',
                'message' => null,
                'created_at' => '2024-03-05 19:36:02',
                'updated_at' => '2024-03-05 19:36:39',
            ],
        ]);

    }
}
