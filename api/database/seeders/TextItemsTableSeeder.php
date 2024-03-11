<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TextItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('text_items')->delete();
        
        \DB::table('text_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Whales',
                'body' => '<p class="main-text">Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.   </p>',
                'show_fleur_de_lis' => 0,
                'sort' => 0,
                'page_id' => 2,
                'created_at' => '2024-03-05 16:15:44',
                'updated_at' => '2024-03-05 16:16:25',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Kontakt',
                'body' => '<p class="main-text">Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.   </p><p class="main-text">Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.   </p>',
                'show_fleur_de_lis' => 0,
                'sort' => 0,
                'page_id' => 3,
                'created_at' => '2024-03-05 17:14:35',
                'updated_at' => '2024-03-05 17:14:42',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Willkommen',
                'body' => '<p class="main-text">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, At accusam aliquyam diam diam dolore dolores duo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore Stet clita ea et gubergren, kasd magna no rebum. sanctus sea sed takimata ut vero voluptua. est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.   </p>',
                'show_fleur_de_lis' => 1,
                'sort' => 0,
                'page_id' => 1,
                'created_at' => '2024-03-05 17:28:54',
                'updated_at' => '2024-03-05 17:30:21',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => '',
                'body' => '<p class="main-text">Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus.  </p>',
                'show_fleur_de_lis' => 0,
                'sort' => 2,
                'page_id' => 1,
                'created_at' => '2024-03-05 17:30:03',
                'updated_at' => '2024-03-05 17:30:21',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Bears',
                'body' => '<p class="main-text">Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.   </p>',
                'show_fleur_de_lis' => 0,
                'sort' => 0,
                'page_id' => 6,
                'created_at' => '2024-03-05 19:33:18',
                'updated_at' => '2024-03-05 19:33:45',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Oops! Diese Seite wurde nicht gefunden.',
                'body' => '',
                'show_fleur_de_lis' => 0,
                'sort' => 0,
                'page_id' => 8,
                'created_at' => '2024-03-05 19:42:26',
                'updated_at' => '2024-03-05 19:42:26',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Mach mit',
                'body' => '<p class="main-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',
                'show_fleur_de_lis' => 0,
                'sort' => 0,
                'page_id' => 9,
                'created_at' => '2024-03-11 20:30:21',
                'updated_at' => '2024-03-11 20:30:21',
            ),
        ));
        
        
    }
}