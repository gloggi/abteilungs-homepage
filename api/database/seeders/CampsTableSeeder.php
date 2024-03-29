<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CampsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('camps')->delete();

        \DB::table('camps')->insert([
            0 => [
                'id' => 1,
                'midata_id' => 2223,
                'name' => 'So-La',
                'description' => 'Beschreibung des SoLas',
                'custom_description' => null,
                'cost' => '350.00',
                'maximum_participants' => null,
                'participant_count' => 0,
                'location' => '',
                'application_opening_at' => null,
                'application_closing_at' => null,
                'application_conditions' => null,
                'canton' => null,
                'external_application_link' => 'https://pbs.puzzle.ch/de/groups/1502/public_events/2223',
                'start_at' => '2024-08-10 00:00:00',
                'finish_at' => '2024-08-23 00:00:00',
                'created_at' => '2024-03-05 16:01:12',
                'updated_at' => '2024-03-05 16:01:12',
            ],
            1 => [
                'id' => 2,
                'midata_id' => 2182,
                'name' => 'He-La',
                'description' => 'He-La description',
                'custom_description' => null,
                'cost' => '220.00',
                'maximum_participants' => 30,
                'participant_count' => 0,
                'location' => 'Camp Adress',
                'application_opening_at' => '2024-01-19',
                'application_closing_at' => '2024-09-25',
                'application_conditions' => null,
                'canton' => null,
                'external_application_link' => 'https://pbs.puzzle.ch/de/groups/1502/public_events/2182',
                'start_at' => '2024-10-05 10:00:00',
                'finish_at' => '2024-10-11 16:00:00',
                'created_at' => '2024-03-05 16:01:12',
                'updated_at' => '2024-03-05 16:01:12',
            ],
        ]);

    }
}
