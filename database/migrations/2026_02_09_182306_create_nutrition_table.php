<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nutrition', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price');
            $table->string('code');
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_base')->default(false);


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nutrition');
    }
};
