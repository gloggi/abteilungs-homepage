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
            0 =>
                array(
                    'id' => 1,
                    'path' => $this->image('images/bear.svg'),
                    'thumbnail' => $this->image('images/bear.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-11 13:02:19',
                    'updated_at' => '2023-12-11 13:02:19',
                ),
            1 =>
                array(
                    'id' => 2,
                    'path' => $this->image('images/camel.svg'),
                    'thumbnail' => $this->image('images/camel.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-11 13:03:11',
                    'updated_at' => '2023-12-11 13:03:11',
                ),
            2 =>
                array(
                    'id' => 3,
                    'path' => $this->image('images/snake.svg'),
                    'thumbnail' => $this->image('images/snake.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-11 13:04:54',
                    'updated_at' => '2023-12-11 13:04:54',
                ),
            3 =>
                array(
                    'id' => 4,
                    'path' => $this->image('images/giraffe.svg'),
                    'thumbnail' => $this->image('images/giraffe.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-11 13:19:18',
                    'updated_at' => '2023-12-11 13:19:18',
                ),
            4 =>
                array(
                    'id' => 5,
                    'path' => $this->image('images/whale.svg'),
                    'thumbnail' => $this->image('images/whale.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-11 13:19:49',
                    'updated_at' => '2023-12-11 13:19:49',
                ),
            5 =>
                array(
                    'id' => 6,
                    'path' => $this->image('images/panda.svg'),
                    'thumbnail' => $this->image('images/panda.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-11 13:20:40',
                    'updated_at' => '2023-12-11 13:20:40',
                ),
            6 =>
                array(
                    'id' => 7,
                    'path' => $this->image('images/owl.svg'),
                    'thumbnail' => $this->image('images/owl.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-11 13:21:22',
                    'updated_at' => '2023-12-11 13:21:22',
                ),
            7 =>
                array(
                    'id' => 31,
                    'path' => $this->image('images/ferix.png'),
                    'thumbnail' => $this->image('images/ferix-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-11 14:31:25',
                    'updated_at' => '2023-12-11 14:31:25',
                ),
            8 =>
                array(
                    'id' => 32,
                    'path' => $this->image('images/rabli.png'),
                    'thumbnail' => $this->image('images/rabli-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-11 14:31:25',
                    'updated_at' => '2023-12-11 14:31:25',
                ),
            9 =>
                array(
                    'id' => 33,
                    'path' => $this->image('images/wisha.png'),
                    'thumbnail' => $this->image('images/wisha-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-11 14:31:25',
                    'updated_at' => '2023-12-11 14:31:25',
                ),
            10 =>
                array(
                    'id' => 34,
                    'path' => $this->image('images/plaesche.png'),
                    'thumbnail' => $this->image('images/plaesche-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-11 14:31:25',
                    'updated_at' => '2023-12-11 14:31:25',
                ),
            11 =>
                array(
                    'id' => 35,
                    'path' => $this->image('images/zusi.png'),
                    'thumbnail' => $this->image('images/zusi-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-11 14:31:25',
                    'updated_at' => '2023-12-11 14:31:25',
                ),
            12 =>
                array(
                    'id' => 38,
                    'path' => $this->image('images/kaya.png'),
                    'thumbnail' => $this->image('images/kaya-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-11 18:19:05',
                    'updated_at' => '2023-12-11 18:19:05',
                ),
            13 =>
                array(
                    'id' => 39,
                    'path' => $this->image('images/rissi.png'),
                    'thumbnail' => $this->image('images/rissi-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-11 18:19:54',
                    'updated_at' => '2023-12-11 18:19:54',
                ),
            14 =>
                array(
                    'id' => 41,
                    'path' => $this->image('images/pio.svg'),
                    'thumbnail' => $this->image('images/pio.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-15 16:56:49',
                    'updated_at' => '2023-12-15 16:56:49',
                ),
            15 =>
                array(
                    'id' => 42,
                    'path' => $this->image('images/fleur-de-lis.svg'),
                    'thumbnail' => $this->image('images/fleur-de-lis.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-15 16:56:49',
                    'updated_at' => '2023-12-15 16:56:49',
                ),
            16 =>
                array(
                    'id' => 43,
                    'path' => $this->image('images/wolf.svg'),
                    'thumbnail' => $this->image('images/wolf.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-15 16:56:49',
                    'updated_at' => '2023-12-15 16:56:49',
                ),
            17 =>
                array(
                    'id' => 44,
                    'path' => $this->image('images/beaver.svg'),
                    'thumbnail' => $this->image('images/beaver.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-15 16:56:49',
                    'updated_at' => '2023-12-15 16:56:49',
                ),
            18 =>
                array(
                    'id' => 49,
                    'path' => $this->image('images/lagom.svg'),
                    'thumbnail' => $this->image('images/lagom.svg'),
                    'extension' => 'svg',
                    'category' => 'general',
                    'created_at' => '2023-12-15 19:22:25',
                    'updated_at' => '2023-12-15 19:22:25',
                ),
            19 =>
                array(
                    'id' => 50,
                    'path' => $this->image('images/banner1.png'),
                    'thumbnail' => $this->image('images/banner1-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-15 19:35:58',
                    'updated_at' => '2023-12-15 19:35:58',
                ),
            20 =>
                array(
                    'id' => 51,
                    'path' => $this->image('images/banner2.png'),
                    'thumbnail' => $this->image('images/banner2-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-15 19:43:08',
                    'updated_at' => '2023-12-15 19:43:08',
                ),
            21 =>
                array(
                    'id' => 52,
                    'path' => $this->image('images/banner3.png'),
                    'thumbnail' => $this->image('images/banner3-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-15 19:43:11',
                    'updated_at' => '2023-12-15 19:43:11',
                ),
            22 =>
                array(
                    'id' => 53,
                    'path' => $this->image('images/banner4.png'),
                    'thumbnail' => $this->image('images/banner4-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-15 19:43:46',
                    'updated_at' => '2023-12-15 19:43:46',
                ),
            23 =>
                array(
                    'id' => 54,
                    'path' => $this->image('images/banner5.png'),
                    'thumbnail' => $this->image('images/banner5-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-15 19:48:45',
                    'updated_at' => '2023-12-15 19:48:45',
                ),
            24 =>
                array(
                    'id' => 55,
                    'path' => $this->image('images/favicon.png'),
                    'thumbnail' => $this->image('images/favicon-thumb.png'),
                    'extension' => 'png',
                    'category' => 'general',
                    'created_at' => '2023-12-19 21:56:24',
                    'updated_at' => '2023-12-19 21:56:24',
                ),
        ));


    }
}
