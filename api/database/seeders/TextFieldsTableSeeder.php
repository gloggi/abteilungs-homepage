<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TextFieldsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('text_fields')->delete();

        \DB::table('text_fields')->insert([
            0 => [
                'id' => 1,
                'uuid' => 'f294979d-7ebd-41bc-b316-b24b13ad2d46',
                'label' => 'Vorname',
                'input_type' => 'text',
                'required' => 1,
                'sort' => 0,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:07:37',
                'updated_at' => '2024-03-05 17:07:49',
            ],
            1 => [
                'id' => 2,
                'uuid' => '18bfe626-d78a-4dd0-90e7-48a91ab97323',
                'label' => 'Nachname',
                'input_type' => 'text',
                'required' => 1,
                'sort' => 1,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:07:49',
                'updated_at' => '2024-03-05 17:08:09',
            ],
            2 => [
                'id' => 3,
                'uuid' => '844624cf-b8cb-44b8-b419-64cba9aa80bc',
                'label' => 'E-Mail',
                'input_type' => 'email',
                'required' => 1,
                'sort' => 2,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:08:09',
                'updated_at' => '2024-03-05 17:08:20',
            ],
            3 => [
                'id' => 4,
                'uuid' => '2f53c309-8a16-41ec-8060-cf63b0ec10b2',
                'label' => 'Geburtstag',
                'input_type' => 'date',
                'required' => 0,
                'sort' => 3,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:08:20',
                'updated_at' => '2024-03-05 17:08:37',
            ],
            4 => [
                'id' => 5,
                'uuid' => '403e741e-29e7-494b-b0b5-df435325056e',
                'label' => 'Geschwister',
                'input_type' => 'number',
                'required' => 0,
                'sort' => 4,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:08:37',
                'updated_at' => '2024-03-05 17:08:59',
            ],
            5 => [
                'id' => 6,
                'uuid' => 'be536091-8415-45a5-a3f1-ff34462475a1',
                'label' => 'Lieblingsuhrzeit',
                'input_type' => 'time',
                'required' => 0,
                'sort' => 5,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:08:59',
                'updated_at' => '2024-03-05 17:09:08',
            ],
            6 => [
                'id' => 7,
                'uuid' => 'e8a0cc86-c901-4462-a7d0-0913eaf025cc',
                'label' => 'Pfadiname',
                'input_type' => 'text',
                'required' => 1,
                'sort' => 0,
                'form_id' => 2,
                'created_at' => '2024-03-05 19:36:48',
                'updated_at' => '2024-03-05 19:37:01',
            ],
        ]);

    }
}
