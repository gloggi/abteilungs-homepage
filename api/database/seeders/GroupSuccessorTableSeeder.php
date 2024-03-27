<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupSuccessorTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('group_successor')->delete();

        \DB::table('group_successor')->insert([
            0 => [
                'id' => 1,
                'group_id' => 1,
                'successor_id' => 4,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'group_id' => 1,
                'successor_id' => 5,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'group_id' => 4,
                'successor_id' => 6,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'group_id' => 4,
                'successor_id' => 10,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'group_id' => 4,
                'successor_id' => 11,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id' => 6,
                'group_id' => 5,
                'successor_id' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id' => 7,
                'group_id' => 6,
                'successor_id' => 8,
                'created_at' => null,
                'updated_at' => null,
            ],
            7 => [
                'id' => 8,
                'group_id' => 8,
                'successor_id' => 9,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

    }
}
