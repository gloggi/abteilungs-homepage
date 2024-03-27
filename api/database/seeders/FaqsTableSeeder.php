<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('faqs')->delete();

        \DB::table('faqs')->insert([
            0 => [
                'id' => 1,
                'group_id' => null,
                'title' => 'Fragen zur Pfadi',
                'created_at' => '2024-03-05 17:09:39',
                'updated_at' => '2024-03-05 17:09:39',
            ],
            1 => [
                'id' => 2,
                'group_id' => 7,
                'title' => 'Whales FAQ',
                'created_at' => '2024-03-05 19:28:45',
                'updated_at' => '2024-03-05 19:29:40',
            ],
        ]);

    }
}
