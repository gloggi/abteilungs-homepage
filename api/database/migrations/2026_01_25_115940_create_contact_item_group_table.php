<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_item_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        $group = DB::table('groups')->where('name', 'Abteilungsstab')->first();
        
        if ($group) {
            $genericItems = DB::table('generic_items')->where('type', 'contactItem')->get();
            
            foreach ($genericItems as $item) {
                $contactItemId = DB::table('contact_items')->insertGetId([
                    'page_id' => $item->page_id,
                    'type' => 'contactItem',
                    'sort' => $item->sort,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ]);

                DB::table('contact_item_group')->insert([
                    'contact_item_id' => $contactItemId,
                    'group_id' => $group->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Delete old GenericItem
                DB::table('generic_items')->where('id', $item->id)->delete();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_item_group');
    }
};
