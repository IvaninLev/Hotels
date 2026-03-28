<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tour_reviews', function (Blueprint $table) {
            $table->json('avatar');
            $table->text('was_in_hotel');
        });
    }

    public function down(): void
    {
        Schema::table('tour_reviews', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('was_in_hotel');
        });
    }
};
