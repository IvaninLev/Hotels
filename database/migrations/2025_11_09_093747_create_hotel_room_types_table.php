<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hotel_room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Hotel::class)->constrained();
            $table->foreignIdFor(\App\Models\RoomType::class)->constrained();
            $table->integer('beds');
            $table->integer('area');
            $table->decimal('price');
            $table->integer('total_rooms');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_room_types');
    }
};
