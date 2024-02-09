<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(){
        Role::findOrCreate('admin');
        Role::findOrCreate('unitleader');
    }
}
