<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(FilesTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PageFileTableSeeder::class);
        $this->call(SectionFileTableSeeder::class);
        $this->call(TextItemsTableSeeder::class);
        $this->call(GenericItemsTableSeeder::class);
        $this->call(ImageItemsTableSeeder::class);
        $this->call(FormsTableSeeder::class);
        $this->call(FormItemsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(TextFieldsTableSeeder::class);
        $this->call(TextareaFieldsTableSeeder::class);
        $this->call(SelectFieldsTableSeeder::class);
        $this->call(OptionFieldsTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
    }
}
