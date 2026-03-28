<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();

            $table->string('room_type');
            $table->integer('max_persons');
            $table->boolean('is_base')->default(false);
            $table->integer('price_per_person');
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
