<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'site_title' => 'Pfadi Lagom',
                'division_name' => 'Pfadi Lagom',
                'midata_id' => 1502,
                'midata_parent_id' => 387,
                'midata_api_key' => 'd_PuHRozzoeEva1dcYebKkB2sUxf4GgceuLGshp68XqvYRWZ-A',
                'division_logo_id' => 49,
                'website_icon_id' => 55,
                'primary_color' => '#006aa7',
                'secondary_color' => '#ffcd00',
                'contact_in_footer' => '<p class="main-text">Footer Text</p>',
                'created_at' => '2023-12-15 20:00:21',
                'updated_at' => '2023-12-19 21:56:27',
            ),
        ));
        
        
    }
}