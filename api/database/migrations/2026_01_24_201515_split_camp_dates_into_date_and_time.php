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
        Schema::table('camps', function (Blueprint $table) {
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('finish_date')->nullable();
            $table->time('finish_time')->nullable();
        });

        $camps = DB::table('camps')->get();
        foreach ($camps as $camp) {
            $updates = [];
            if ($camp->start_at) {
                $updates['start_date'] = \Carbon\Carbon::parse($camp->start_at)->toDateString();
                $updates['start_time'] = \Carbon\Carbon::parse($camp->start_at)->toTimeString();
            }
            if ($camp->finish_at) {
                $updates['finish_date'] = \Carbon\Carbon::parse($camp->finish_at)->toDateString();
                $updates['finish_time'] = \Carbon\Carbon::parse($camp->finish_at)->toTimeString();
            }
            if (! empty($updates)) {
                DB::table('camps')->where('id', $camp->id)->update($updates);
            }
        }

        Schema::table('camps', function (Blueprint $table) {
            $table->dropColumn(['start_at', 'finish_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('camps', function (Blueprint $table) {
            $table->dateTime('start_at')->nullable();
            $table->dateTime('finish_at')->nullable();
        });

        $camps = DB::table('camps')->get();
        foreach ($camps as $camp) {
            $updates = [];
            if ($camp->start_date) {
                $time = $camp->start_time ?: '00:00:00';
                $updates['start_at'] = $camp->start_date.' '.$time;
            }
            if ($camp->finish_date) {
                $time = $camp->finish_time ?: '00:00:00';
                $updates['finish_at'] = $camp->finish_date.' '.$time;
            }
            if (! empty($updates)) {
                DB::table('camps')->where('id', $camp->id)->update($updates);
            }
        }

        Schema::table('camps', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'start_time', 'finish_date', 'finish_time']);
        });
    }
};
