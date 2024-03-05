<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'migration' => '2014_10_12_100000_create_password_reset_tokens_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'migration' => '2018_08_08_100000_create_telescope_entries_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'migration' => '2019_08_19_000000_create_failed_jobs_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'migration' => '2019_12_14_000001_create_personal_access_tokens_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'migration' => '2023_03_27_183543_create_files_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'migration' => '2023_03_28_200247_create_sections_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'migration' => '2023_03_28_200338_create_groups_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'migration' => '2023_04_01_113934_create_invites_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'migration' => '2023_05_08_060153_create_contacts_table',
                'batch' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'migration' => '2023_05_09_103125_create_group_predecessor_table',
                'batch' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'migration' => '2023_05_09_103134_create_group_successor_table',
                'batch' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'migration' => '2023_05_09_153823_create_forms_and_fields_tables',
                'batch' => 1,
            ),
            13 => 
            array (
                'id' => 14,
                'migration' => '2023_12_08_212623_create_pages_table',
                'batch' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'migration' => '2023_12_09_152759_create_menu_items',
                'batch' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'migration' => '2023_12_10_162747_create_settings_table',
                'batch' => 1,
            ),
            16 => 
            array (
                'id' => 17,
                'migration' => '2023_12_10_192828_create_locations_table',
                'batch' => 1,
            ),
            17 => 
            array (
                'id' => 18,
                'migration' => '2023_12_10_215500_create_events_table',
                'batch' => 1,
            ),
            18 => 
            array (
                'id' => 19,
                'migration' => '2023_12_13_181124_create_permission_tables',
                'batch' => 1,
            ),
            19 => 
            array (
                'id' => 20,
                'migration' => '2023_12_18_172637_create_camp_table',
                'batch' => 1,
            ),
            20 => 
            array (
                'id' => 21,
                'migration' => '2024_01_01_164912_create_footer_links_table',
                'batch' => 1,
            ),
            21 => 
            array (
                'id' => 22,
                'migration' => '2024_02_15_000000_create_user_groups_table',
                'batch' => 1,
            ),
            22 => 
            array (
                'id' => 23,
                'migration' => '2024_02_17_121031_create_event_files_table',
                'batch' => 1,
            ),
            23 => 
            array (
                'id' => 24,
                'migration' => '2024_02_17_161541_add_user_id_to_events_table',
                'batch' => 1,
            ),
            24 => 
            array (
                'id' => 25,
                'migration' => '2024_02_18_112909_enable_group_page_to_groups_table',
                'batch' => 1,
            ),
            25 => 
            array (
                'id' => 26,
                'migration' => '2024_02_18_185901_create_location_items_table',
                'batch' => 1,
            ),
            26 => 
            array (
                'id' => 27,
                'migration' => '2024_02_20_205642_remove_settings_parent_id',
                'batch' => 1,
            ),
            27 => 
            array (
                'id' => 28,
                'migration' => '2024_02_20_211205_create_faqs_table',
                'batch' => 1,
            ),
            28 => 
            array (
                'id' => 29,
                'migration' => '2024_02_21_125508_create_faq_items_table',
                'batch' => 1,
            ),
            29 => 
            array (
                'id' => 30,
                'migration' => '2024_02_21_185001_add_alert_to_settings_table',
                'batch' => 1,
            ),
            30 => 
            array (
                'id' => 31,
                'migration' => '2024_02_24_164321_add_not_found_page_to_settings_table',
                'batch' => 1,
            ),
            31 => 
            array (
                'id' => 32,
                'migration' => '2024_02_26_202430_add_user_to_files_table',
                'batch' => 1,
            ),
            32 => 
            array (
                'id' => 33,
                'migration' => '2024_02_28_195517_add_group_id_to_pages_table',
                'batch' => 1,
            ),
            33 => 
            array (
                'id' => 34,
                'migration' => '2024_03_02_121618_add_group_to_faqs_forms_and_files_table',
                'batch' => 1,
            ),
            34 => 
            array (
                'id' => 35,
                'migration' => '2024_03_04_123552_change_precision_of_lat_lon_in_locations_table',
                'batch' => 1,
            ),
        ));
        
        
    }
}