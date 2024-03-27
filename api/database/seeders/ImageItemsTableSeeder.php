<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImageItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('image_items')->delete();

        \DB::table('image_items')->insert([
            0 => [
                'id' => 1,
                'sort' => 2,
                'page_id' => 2,
                'created_at' => '2024-03-05 17:27:52',
                'updated_at' => '2024-03-05 19:31:15',
            ],
            1 => [
                'id' => 2,
                'sort' => 1,
                'page_id' => 1,
                'created_at' => '2024-03-05 17:29:38',
                'updated_at' => '2024-03-05 17:29:38',
            ],
        ]);

    }
}
