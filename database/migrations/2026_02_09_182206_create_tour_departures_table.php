<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tour_departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->decimal('extra_price');
            $table->foreignId('airport_id')->constrained()->cascadeOnDelete();
            $table->foreignId('return_airport_id')->constrained('airports')->cascadeOnDelete();
            $table->integer('night_count');
            $table->dateTime('departure_date');
            $table->dateTime('arrival_date');
            $table->dateTime('return_date');
            $table->dateTime('return_arrival_date');


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_departures');
    }
};
