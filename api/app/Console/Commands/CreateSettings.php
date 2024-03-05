<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Schema;

use Spatie\Permission\Models\Role;

class CreateSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create settings from .env if they do not already exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Role::findOrCreate('admin');
        Role::findOrCreate('unitleader');
        $this->info('Roles created');

        if (!Schema::hasTable('settings')) {
            $this->error('The settings table does not exist!');
            return;
        }

        $settings = [
            'midata_id' => env('MIDATA_ID'),
        ];

        $existingSettings = DB::table('settings')->first();

        if (!$existingSettings) {
           
            DB::table('settings')->insert([$settings]);
            $this->info("All settings have been inserted.");
        } else {
            
            foreach ($settings as $key => $value) {
                if (is_null($existingSettings->{$key})) {
                    DB::table('settings')
                        ->updateOrInsert(
                            ['id' => $existingSettings->id],
                            [$key => $value]
                        );
                    $this->info("Updated $key with value $value");
                } else {
                    $this->info("Skipped $key as it already has a value");
                }
            }
        }
    }
}
