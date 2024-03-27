<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionFileTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('section_file')->delete();

        \DB::table('section_file')->insert([
            0 => [
                'section_id' => 1,
                'file_id' => 27,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'section_id' => 2,
                'file_id' => 31,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'section_id' => 2,
                'file_id' => 32,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'section_id' => 3,
                'file_id' => 24,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'section_id' => 4,
                'file_id' => 33,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'section_id' => 5,
                'file_id' => 25,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

    }
}
