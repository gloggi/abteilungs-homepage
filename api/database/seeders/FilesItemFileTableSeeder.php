<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FilesItemFileTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('files_item_file')->delete();

    }
}
