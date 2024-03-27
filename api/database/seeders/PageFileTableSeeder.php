<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PageFileTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('page_file')->delete();

        \DB::table('page_file')->insert([
            0 => [
                'page_id' => 1,
                'file_id' => 28,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'page_id' => 1,
                'file_id' => 35,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'page_id' => 1,
                'file_id' => 27,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'page_id' => 2,
                'file_id' => 29,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'page_id' => 3,
                'file_id' => 23,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'page_id' => 4,
                'file_id' => 30,
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'page_id' => 5,
                'file_id' => 31,
                'created_at' => null,
                'updated_at' => null,
            ],
            7 => [
                'page_id' => 6,
                'file_id' => 34,
                'created_at' => null,
                'updated_at' => null,
            ],
            8 => [
                'page_id' => 7,
                'file_id' => 33,
                'created_at' => null,
                'updated_at' => null,
            ],
            9 => [
                'page_id' => 9,
                'file_id' => 31,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

    }
}
