<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('external_id');
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
