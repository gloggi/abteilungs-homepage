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
        $this->call(FilesTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
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
        $this->call(GroupPredecessorTableSeeder::class);
        $this->call(GroupSuccessorTableSeeder::class);
        $this->call(ImageItemFileTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(EventGroupsTableSeeder::class);
        $this->call(LocationItemsTableSeeder::class);
        $this->call(FilesItemsTableSeeder::class);
        $this->call(FilesItemFileTableSeeder::class);
        $this->call(CampsTableSeeder::class);
        $this->call(FaqsTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(FooterLinksTableSeeder::class);
        $this->call(FaqItemsTableSeeder::class);
        $this->call(EventFilesTableSeeder::class);
        $this->call(GroupEventsItemsTableSeeder::class);
    }
    // create seeds: php artisan iseed contacts,page_file,location_items,option_fields,text_fields,image_items,settings,files_items,files_item_file,groups,menu_items,events,text_items,camps,section_file,migrations,questions,files,pages,footer_links,locations,faq_items,faqs,group_predecessor,textarea_fields,select_fields,form_items,group_successor,forms,generic_items,image_item_file,sections,event_files,group_events_items,event_groups --force
}
