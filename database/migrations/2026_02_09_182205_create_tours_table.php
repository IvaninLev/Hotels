<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->integer('persons');
            $table->json('images')->nullable();
            $table->timestamp('active_from');
            $table->timestamp('active_to');
            $table->decimal('base_price', 8, 2);
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
