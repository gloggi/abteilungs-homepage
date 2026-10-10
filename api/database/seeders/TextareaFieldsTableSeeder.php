<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TextareaFieldsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('textarea_fields')->delete();

        \DB::table('textarea_fields')->insert([
            0 => [
                'id' => 1,
                'uuid' => '1c6a4909-6db9-4bf8-a1b9-b9fd34a63b91',
                'label' => 'Nachricht',
                'required' => 1,
                'sort' => 6,
                'form_id' => 1,
                'created_at' => '2024-03-05 17:09:08',
                'updated_at' => '2024-03-05 17:09:21',
            ],
            1 => [
                'id' => 2,
                'uuid' => '37832b0f-c2e4-4cd0-a275-fd759990e0f7',
                'label' => 'Nachricht',
                'required' => 1,
                'sort' => 1,
                'form_id' => 2,
                'created_at' => '2024-03-05 19:37:01',
                'updated_at' => '2024-03-05 19:37:08',
            ],
        ]);

    }
}
