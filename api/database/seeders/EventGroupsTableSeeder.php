<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventGroupsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('event_groups')->delete();

        \DB::table('event_groups')->insert([
            0 => [
                'id' => 11,
                'event_id' => 11,
                'group_id' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 12,
                'event_id' => 12,
                'group_id' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 13,
                'event_id' => 13,
                'group_id' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 14,
                'event_id' => 14,
                'group_id' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 15,
                'event_id' => 15,
                'group_id' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id' => 16,
                'event_id' => 16,
                'group_id' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id' => 19,
                'event_id' => 19,
                'group_id' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

    }
}
