<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('files')->delete();
        
        \DB::table('files')->insert(array (
            0 => 
            array (
                'id' => 1,
                'path' => '/storage/uploads/1702299739.svg',
                'thumbnail' => '/storage/uploads/1702299739.svg',
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2023-12-11 13:02:19',
                'updated_at' => '2023-12-11 13:02:19',
            ),
            1 => 
            array (
                'id' => 2,
                'path' => '/storage/uploads/1702299791.svg',
                'thumbnail' => '/storage/uploads/1702299791.svg',
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2023-12-11 13:03:11',
                'updated_at' => '2023-12-11 13:03:11',
            ),
            2 => 
            array (
                'id' => 3,
                'path' => '/storage/uploads/1702299894.svg',
                'thumbnail' => '/storage/uploads/1702299894.svg',
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2023-12-11 13:04:54',
                'updated_at' => '2023-12-11 13:04:54',
            ),
            3 => 
            array (
                'id' => 4,
                'path' => '/storage/uploads/1702300758.svg',
                'thumbnail' => '/storage/uploads/1702300758.svg',
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2023-12-11 13:19:18',
                'updated_at' => '2023-12-11 13:19:18',
            ),
            4 => 
            array (
                'id' => 5,
                'path' => '/storage/uploads/1702300789.svg',
                'thumbnail' => '/storage/uploads/1702300789.svg',
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2023-12-11 13:19:49',
                'updated_at' => '2023-12-11 13:19:49',
            ),
            5 => 
            array (
                'id' => 6,
                'path' => '/storage/uploads/1702300840.svg',
                'thumbnail' => '/storage/uploads/1702300840.svg',
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2023-12-11 13:20:40',
                'updated_at' => '2023-12-11 13:20:40',
            ),
            6 => 
            array (
                'id' => 7,
                'path' => '/storage/uploads/1702300882.svg',
                'thumbnail' => '/storage/uploads/1702300882.svg',
                'extension' => 'svg',
                'category' => 'general',
                'created_at' => '2023-12-11 13:21:22',
                'updated_at' => '2023-12-11 13:21:22',
            ),
            7 => 
            array (
                'id' => 31,
                'path' => '/storage/uploads/1702305085_1295662797.png',
                'thumbnail' => '/storage/thumbnails/1702305085_1295662797.png',
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2023-12-11 14:31:25',
                'updated_at' => '2023-12-11 14:31:25',
            ),
            8 => 
            array (
                'id' => 32,
                'path' => '/storage/uploads/1702305085_750567387.png',
                'thumbnail' => '/storage/thumbnails/1702305085_750567387.png',
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2023-12-11 14:31:25',
                'updated_at' => '2023-12-11 14:31:25',
            ),
            9 => 
            array (
                'id' => 33,
                'path' => '/storage/uploads/1702305085_664073622.png',
                'thumbnail' => '/storage/thumbnails/1702305085_664073622.png',
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2023-12-11 14:31:25',
                'updated_at' => '2023-12-11 14:31:25',
            ),
            10 => 
            array (
                'id' => 34,
                'path' => '/storage/uploads/1702305085_1761888946.png',
                'thumbnail' => '/storage/thumbnails/1702305085_1761888946.png',
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2023-12-11 14:31:25',
                'updated_at' => '2023-12-11 14:31:25',
            ),
            11 => 
            array (
                'id' => 35,
                'path' => '/storage/uploads/1702305085_1853838749.png',
                'thumbnail' => '/storage/thumbnails/1702305085_1853838749.png',
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2023-12-11 14:31:25',
                'updated_at' => '2023-12-11 14:31:25',
            ),
            12 => 
            array (
                'id' => 38,
                'path' => '/storage/uploads/1702318745_1257752853.png',
                'thumbnail' => '/storage/thumbnails/1702318745_1257752853.png',
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2023-12-11 18:19:05',
                'updated_at' => '2023-12-11 18:19:05',
            ),
            13 => 
            array (
                'id' => 39,
                'path' => '/storage/uploads/1702318794_1110055061.png',
                'thumbnail' => '/storage/thumbnails/1702318794_1110055061.png',
                'extension' => 'png',
                'category' => 'general',
                'created_at' => '2023-12-11 18:19:54',
                'updated_at' => '2023-12-11 18:19:54',
            ),
        ));
        
        
    }
}