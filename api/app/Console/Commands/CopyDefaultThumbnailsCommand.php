<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CopyDefaultThumbnailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbnails:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies default thumbnails from resources to the storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thumbnails = [
            'docx.svg',
            'xlsx.svg',
            'pptx.svg',
            'mp3.svg',
            'mp4.svg',
            'zip.svg',
        ];

        foreach ($thumbnails as $filename) {
            $path = "default_thumbnails/{$filename}";
            Storage::disk('public')
                ->putFileAs('default_thumbnails', resource_path($path), basename($path));
        }
    }
}
