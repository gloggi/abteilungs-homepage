<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::table('text_fields', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
        });
        DB::table('text_fields')->get()->each(function ($record) {
            DB::table('text_fields')->where('id', $record->id)->update(['uuid' => (string) Str::uuid()]);
        });
        Schema::table('text_fields', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('textarea_fields', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
        });
        DB::table('textarea_fields')->get()->each(function ($record) {
            DB::table('textarea_fields')->where('id', $record->id)->update(['uuid' => (string) Str::uuid()]);
        });
        Schema::table('textarea_fields', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('select_fields', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
        });
        DB::table('select_fields')->get()->each(function ($record) {
            DB::table('select_fields')->where('id', $record->id)->update(['uuid' => (string) Str::uuid()]);
        });
        Schema::table('select_fields', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('option_fields', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
        });
        DB::table('option_fields')->get()->each(function ($record) {
            DB::table('option_fields')->where('id', $record->id)->update(['uuid' => (string) Str::uuid()]);
        });
        Schema::table('option_fields', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('text_fields', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('textarea_fields', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('select_fields', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('option_fields', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
