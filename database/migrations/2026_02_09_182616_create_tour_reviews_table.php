<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tour_reviews', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('main_text');

            $table->string('person_from')->nullable();

            $table->string('flight_to')->nullable();

            $table->unsignedTinyInteger('rating');

            $table->date('flight_date')->nullable();

            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_reviews');
    }
};
