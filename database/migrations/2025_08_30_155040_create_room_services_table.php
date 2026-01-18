<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rooms_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\RoomType::class)->constrained();
            $table->foreignIdFor(\App\Models\RoomService::class)->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms_services');
    }
};
