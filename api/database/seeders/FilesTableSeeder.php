<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FilesTableSeeder extends Seeder
{

    protected function image($path) {
        return Storage::url(
            Storage::disk('public')
                ->putFileAs('images', resource_path($path), basename($path))
        );
    }

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('files')->delete();
        
        \DB::table('files')->insert(array(
            0 => array(
                'id' => '1',
                'name' => 'lagom',
                'path' => $this->image('images/lagom.svg'),
                'thumbnail' => $this->image('images/lagom.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 14:47:58',
                'updated_at' => '2024-03-05 14:47:58'
            ),
            1 => array(
                'id' => '2',
                'name' => 'favicon',
                'path' => $this->image('images/favicon.png'),
                'thumbnail' => $this->image('images/favicon-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 14:49:31',
                'updated_at' => '2024-03-05 14:49:31'
            ),
            2 => array(
                'id' => '3',
                'name' => 'rissi',
                'path' => $this->image('images/rissi.jpg'),
                'thumbnail' => $this->image('images/rissi-thumbnail.jpg'),
                'extension' => 'jpg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:09:45',
                'updated_at' => '2024-03-05 19:59:59'
            ),
            3 => array(
                'id' => '4',
                'name' => 'zusi',
                'path' => $this->image('images/zusi.png'),
                'thumbnail' => $this->image('images/zusi-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 15:10:50',
                'updated_at' => '2024-03-05 19:59:50'
            ),
            4 => array(
                'id' => '5',
                'name' => 'kaya',
                'path' => $this->image('images/kaya.png'),
                'thumbnail' => $this->image('images/kaya-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 15:12:28',
                'updated_at' => '2024-03-05 19:59:39'
            ),
            5 => array(
                'id' => '6',
                'name' => 'wisha',
                'path' => $this->image('images/wisha.png'),
                'thumbnail' => $this->image('images/wisha-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 15:13:33',
                'updated_at' => '2024-03-05 19:59:30'
            ),
            6 => array(
                'id' => '7',
                'name' => 'plaesche',
                'path' => $this->image('images/plaesche.png'),
                'thumbnail' => $this->image('images/plaesche-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 15:14:30',
                'updated_at' => '2024-03-05 19:59:04'
            ),
            7 => array(
                'id' => '8',
                'name' => 'ferix',
                'path' => $this->image('images/ferix.png'),
                'thumbnail' => $this->image('images/ferix-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 15:15:45',
                'updated_at' => '2024-03-05 19:58:52'
            ),
            8 => array(
                'id' => '9',
                'name' => 'zusi',
                'path' => $this->image('images/zusi.png'),
                'thumbnail' => $this->image('images/zusi-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 15:17:10',
                'updated_at' => '2024-03-05 19:58:36'
            ),
            9 => array(
                'id' => '10',
                'name' => 'beaver',
                'path' => $this->image('images/beaver.svg'),
                'thumbnail' => $this->image('images/beaver.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:20:25',
                'updated_at' => '2024-03-05 15:20:25'
            ),
            10 => array(
                'id' => '11',
                'name' => 'wolf',
                'path' => $this->image('images/wolf.svg'),
                'thumbnail' => $this->image('images/wolf.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:20:53',
                'updated_at' => '2024-03-05 15:20:53'
            ),
            11 => array(
                'id' => '12',
                'name' => 'fleur-de-lis',
                'path' => $this->image('images/fleur-de-lis.svg'),
                'thumbnail' => $this->image('images/fleur-de-lis.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:21:12',
                'updated_at' => '2024-03-05 15:21:12'
            ),
            12 => array(
                'id' => '13',
                'name' => 'pio',
                'path' => $this->image('images/pio.svg'),
                'thumbnail' => $this->image('images/pio.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:21:32',
                'updated_at' => '2024-03-05 15:21:32'
            ),
            13 => array(
                'id' => '14',
                'name' => 'bear',
                'path' => $this->image('images/bear.svg'),
                'thumbnail' => $this->image('images/bear.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:23:49',
                'updated_at' => '2024-03-05 19:58:07'
            ),
            14 => array(
                'id' => '15',
                'name' => 'camel',
                'path' => $this->image('images/camel.svg'),
                'thumbnail' => $this->image('images/camel.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:24:16',
                'updated_at' => '2024-03-05 19:58:03'
            ),
            15 => array(
                'id' => '16',
                'name' => 'snake',
                'path' => $this->image('images/snake.svg'),
                'thumbnail' => $this->image('images/snake.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:24:28',
                'updated_at' => '2024-03-05 19:57:54'
            ),
            16 => array(
                'id' => '17',
                'name' => 'giraffe',
                'path' => $this->image('images/giraffe.svg'),
                'thumbnail' => $this->image('images/giraffe.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:24:42',
                'updated_at' => '2024-03-05 19:57:49'
            ),
            17 => array(
                'id' => '18',
                'name' => 'whale',
                'path' => $this->image('images/whale.svg'),
                'thumbnail' => $this->image('images/whale.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:25:01',
                'updated_at' => '2024-03-05 19:57:34'
            ),
            18 => array(
                'id' => '19',
                'name' => 'panda',
                'path' => $this->image('images/panda.svg'),
                'thumbnail' => $this->image('images/panda.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:25:16',
                'updated_at' => '2024-03-05 19:57:27'
            ),
            19 => array(
                'id' => '20',
                'name' => 'owl',
                'path' => $this->image('images/owl.svg'),
                'thumbnail' => $this->image('images/owl.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:25:32',
                'updated_at' => '2024-03-05 19:57:21'
            ),
            20 => array(
                'id' => '21',
                'name' => 'koala',
                'path' => $this->image('images/koala.svg'),
                'thumbnail' => $this->image('images/koala.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:49:23',
                'updated_at' => '2024-03-05 19:57:16'
            ),
            21 => array(
                'id' => '22',
                'name' => 'monkey',
                'path' => $this->image('images/monkey.svg'),
                'thumbnail' => $this->image('images/monkey.svg'),
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2024-03-05 15:51:22',
                'updated_at' => '2024-03-05 19:57:02'
            ),
            22 => array(
                'id' => '23',
                'name' => 'banner_03',
                'path' => $this->image('images/banner_03.png'),
                'thumbnail' => $this->image('images/banner_03-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:30',
                'updated_at' => '2024-03-05 17:26:30'
            ),
            23 => array(
                'id' => '24',
                'name' => 'banner_17',
                'path' => $this->image('images/banner_17.png'),
                'thumbnail' => $this->image('images/banner_17-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:31',
                'updated_at' => '2024-03-05 17:26:31'
            ),
            24 => array(
                'id' => '25',
                'name' => 'banner_16',
                'path' => $this->image('images/banner_16.png'),
                'thumbnail' => $this->image('images/banner_16-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:31',
                'updated_at' => '2024-03-05 17:26:31'
            ),
            25 => array(
                'id' => '26',
                'name' => 'banner_04',
                'path' => $this->image('images/banner_04.png'),
                'thumbnail' => $this->image('images/banner_04-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:31',
                'updated_at' => '2024-03-05 17:26:31'
            ),
            26 => array(
                'id' => '27',
                'name' => 'banner_02',
                'path' => $this->image('images/banner_02.png'),
                'thumbnail' => $this->image('images/banner_02-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:31',
                'updated_at' => '2024-03-05 17:26:31'
            ),
            27 => array(
                'id' => '28',
                'name' => 'banner_01',
                'path' => $this->image('images/banner_01.png'),
                'thumbnail' => $this->image('images/banner_01-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:31',
                'updated_at' => '2024-03-05 17:26:31'
            ),
            28 => array(
                'id' => '29',
                'name' => 'banner_05',
                'path' => $this->image('images/banner_05.png'),
                'thumbnail' => $this->image('images/banner_05-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:31',
                'updated_at' => '2024-03-05 17:26:31'
            ),
            29 => array(
                'id' => '30',
                'name' => 'banner_06',
                'path' => $this->image('images/banner_06.png'),
                'thumbnail' => $this->image('images/banner_06-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:32',
                'updated_at' => '2024-03-05 17:26:32'
            ),
            30 => array(
                'id' => '31',
                'name' => 'banner_09',
                'path' => $this->image('images/banner_09.png'),
                'thumbnail' => $this->image('images/banner_09-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:32',
                'updated_at' => '2024-03-05 17:26:32'
            ),
            31 => array(
                'id' => '32',
                'name' => 'banner_10',
                'path' => $this->image('images/banner_10.png'),
                'thumbnail' => $this->image('images/banner_10-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:32',
                'updated_at' => '2024-03-05 17:26:32'
            ),
            32 => array(
                'id' => '33',
                'name' => 'banner_08',
                'path' => $this->image('images/banner_08.png'),
                'thumbnail' => $this->image('images/banner_08-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:32',
                'updated_at' => '2024-03-05 17:26:32'
            ),
            33 => array(
                'id' => '34',
                'name' => 'banner_15',
                'path' => $this->image('images/banner_15.png'),
                'thumbnail' => $this->image('images/banner_15-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:32',
                'updated_at' => '2024-03-05 17:26:32'
            ),
            34 => array(
                'id' => '35',
                'name' => 'banner_07',
                'path' => $this->image('images/banner_07.png'),
                'thumbnail' => $this->image('images/banner_07-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:33',
                'updated_at' => '2024-03-05 17:26:33'
            ),
            35 => array(
                'id' => '36',
                'name' => 'banner_14',
                'path' => $this->image('images/banner_14.png'),
                'thumbnail' => $this->image('images/banner_14-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:33',
                'updated_at' => '2024-03-05 17:26:33'
            ),
            36 => array(
                'id' => '37',
                'name' => 'banner_11',
                'path' => $this->image('images/banner_11.png'),
                'thumbnail' => $this->image('images/banner_11-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:33',
                'updated_at' => '2024-03-05 17:26:33'
            ),
            37 => array(
                'id' => '38',
                'name' => 'banner_12',
                'path' => $this->image('images/banner_12.png'),
                'thumbnail' => $this->image('images/banner_12-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:33',
                'updated_at' => '2024-03-05 17:26:33'
            ),
            38 => array(
                'id' => '39',
                'name' => 'banner_13',
                'path' => $this->image('images/banner_13.png'),
                'thumbnail' => $this->image('images/banner_13-thumbnail.png'),
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2024-03-05 17:26:34',
                'updated_at' => '2024-03-05 17:26:34'
            ),
        ));
        
        
    }
}
