<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hotel_reviews', function (Blueprint $table) {
            $table->id();

            $table->string('person_name');
            $table->string('person_second_name')->nullable();

            $table->foreignId('from_city_id')->constrained('cities')->cascadeOnDelete();

            $table->text('main_text');
            $table->date('review_date');

            $table->string('rating_for_food');
            $table->string('rating_for_room');
            $table->string('rating_price_quality');
            $table->string('rating_for_beach');

            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('hotel_reviews', function (Blueprint $table) {
            $table->dropForeign(['from_city_id']);
            $table->dropForeign(['hotel_id']);
        });

        Schema::dropIfExists('hotel_reviews');
    }
};
