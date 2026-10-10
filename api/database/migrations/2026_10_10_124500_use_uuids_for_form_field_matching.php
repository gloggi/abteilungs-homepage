<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    private const FIELD_TABLES = [
        'text_fields',
        'textarea_fields',
        'select_fields',
        'option_fields',
    ];

    public function up(): void
    {
        foreach (self::FIELD_TABLES as $tableName) {
            $this->backfillUuids($tableName);

            Schema::table($tableName, function (Blueprint $table) {
                $table->unique('uuid');
            });
        }

        Schema::table('forms', function (Blueprint $table) {
            $table->uuid('autoresponse_email_field_uuid')->nullable()->after('autoresponse_email_field_id');
        });

        DB::table('forms')
            ->whereNotNull('autoresponse_email_field_id')
            ->select(['id', 'autoresponse_email_field_id'])
            ->lazyById()
            ->each(function ($form) {
                $uuid = DB::table('text_fields')
                    ->where('id', $form->autoresponse_email_field_id)
                    ->where('form_id', $form->id)
                    ->value('uuid');

                DB::table('forms')
                    ->where('id', $form->id)
                    ->update(['autoresponse_email_field_uuid' => $uuid]);
            });

        Schema::table('forms', function (Blueprint $table) {
            $table->dropForeign(['autoresponse_email_field_id']);
            $table->dropColumn('autoresponse_email_field_id');
        });
    }

    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->unsignedBigInteger('autoresponse_email_field_id')->nullable()->after('autoresponse_email_field_uuid');
        });

        DB::table('forms')
            ->whereNotNull('autoresponse_email_field_uuid')
            ->select(['id', 'autoresponse_email_field_uuid'])
            ->lazyById()
            ->each(function ($form) {
                $id = DB::table('text_fields')
                    ->where('uuid', $form->autoresponse_email_field_uuid)
                    ->where('form_id', $form->id)
                    ->value('id');

                DB::table('forms')
                    ->where('id', $form->id)
                    ->update(['autoresponse_email_field_id' => $id]);
            });

        Schema::table('forms', function (Blueprint $table) {
            $table->foreign('autoresponse_email_field_id')->references('id')->on('text_fields')->onDelete('cascade');
            $table->dropColumn('autoresponse_email_field_uuid');
        });

        foreach (self::FIELD_TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropUnique(['uuid']);
            });
        }
    }

    /**
     * Assigns a fresh UUID to every row whose UUID is missing, invalid or a
     * duplicate of an earlier row, so the unique index can be created safely.
     */
    private function backfillUuids(string $tableName): void
    {
        $seen = [];

        DB::table($tableName)
            ->select(['id', 'uuid'])
            ->lazyById()
            ->each(function ($row) use ($tableName, &$seen) {
                $uuid = is_string($row->uuid) ? strtolower(trim($row->uuid)) : '';

                if (! Str::isUuid($uuid) || isset($seen[$uuid])) {
                    do {
                        $uuid = (string) Str::uuid();
                    } while (isset($seen[$uuid]));

                    DB::table($tableName)->where('id', $row->id)->update(['uuid' => $uuid]);
                }

                $seen[$uuid] = true;
            });
    }
};
