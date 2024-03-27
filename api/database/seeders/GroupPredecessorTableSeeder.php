<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupPredecessorTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('group_predecessor')->delete();

        \DB::table('group_predecessor')->insert([
            0 => [
                'id' => 1,
                'group_id' => 4,
                'predecessor_id' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'group_id' => 5,
                'predecessor_id' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'group_id' => 6,
                'predecessor_id' => 4,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'group_id' => 7,
                'predecessor_id' => 5,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'group_id' => 8,
                'predecessor_id' => 6,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id' => 6,
                'group_id' => 8,
                'predecessor_id' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id' => 7,
                'group_id' => 8,
                'predecessor_id' => 10,
                'created_at' => null,
                'updated_at' => null,
            ],
            7 => [
                'id' => 8,
                'group_id' => 8,
                'predecessor_id' => 11,
                'created_at' => null,
                'updated_at' => null,
            ],
            8 => [
                'id' => 9,
                'group_id' => 9,
                'predecessor_id' => 8,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

    }
}
