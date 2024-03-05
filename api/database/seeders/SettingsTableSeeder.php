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
                'midata_api_key' => 'd_PuHRozzoeEva1dcYebKkB2sUxf4GgceuLGshp68XqvYRWZ-A',
                'division_logo_id' => 1,
                'website_icon_id' => 2,
                'primary_color' => '#006aa7',
                'secondary_color' => '#ffcd00',
                'contact_in_footer' => '<p class="main-text">Lorem Ipsum</p><p class="main-text">Ipsum 1234</p><p class="main-text">1234 Ipsum</p>',
                'alert_text' => '🏕️ Bald findet der Pfadi-Schnuppertag statt. Klicke hier, für mehr Infos!',
                'alert_bg_color' => '#a73d00',
                'alert_text_color' => '#ffffff',
                'show_alert' => 1,
                'alert_url' => 'https://demo.gloggi.ch/schnuppertag',
                'created_at' => NULL,
                'updated_at' => '2024-03-05 19:42:36',
                'not_found_page_id' => 8,
            ),
        ));
        
        
    }
}