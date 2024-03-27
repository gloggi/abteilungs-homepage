<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventFilesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('event_files')->delete();

    }
}
