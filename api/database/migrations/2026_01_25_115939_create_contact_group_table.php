<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Data Migration: Assign all existing contacts to "Abteilungsstab"
        $group = DB::table('groups')->where('name', 'Abteilungsstab')->first();
        if ($group) {
            $contacts = DB::table('contacts')->get();
            foreach ($contacts as $contact) {
                DB::table('contact_group')->insert([
                    'contact_id' => $contact->id,
                    'group_id' => $group->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_group');
    }
};
