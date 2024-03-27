<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImageItemFileTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('image_item_file')->delete();

        \DB::table('image_item_file')->insert([
            0 => [
                'image_item_id' => 1,
                'file_id' => 30,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'image_item_id' => 1,
                'file_id' => 25,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'image_item_id' => 1,
                'file_id' => 24,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'image_item_id' => 2,
                'file_id' => 36,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'image_item_id' => 2,
                'file_id' => 39,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

    }
}
