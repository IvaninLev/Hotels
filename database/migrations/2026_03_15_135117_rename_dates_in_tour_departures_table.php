<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tour_departures', function (Blueprint $table) {
            $table->dropColumn('departure_time');
            $table->dropColumn('arrival_time');
            $table->dropColumn('return_time');
            $table->dropColumn('return_arrival_time');
            $table->dropColumn('departure_date');
            $table->dropColumn('arrival_date');
            $table->dropColumn('return_date');
            $table->dropColumn('return_arrival_date');

            $table->dateTime('departure_date');
            $table->dateTime('arrival_date');
            $table->dateTime('return_date');
            $table->dateTime('return_arrival_date');
        });
    }

    public function down(): void
    {
        Schema::table('tour_departures', function (Blueprint $table) {
            $table->dropColumn('departure_date');
            $table->dropColumn('arrival_date');
            $table->dropColumn('return_date');
            $table->dropColumn('return_arrival_date');

            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('arrival_date');
            $table->time('arrival_time');
            $table->date('return_date');
            $table->time('return_time');
            $table->date('return_arrival_date');
            $table->time('return_arrival_time');
        });
    }
};
