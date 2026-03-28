<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tour_reviews', function (Blueprint $table) {
            $table->dropForeign('tour_reviews_tour_id_foreign');
            $table->dropColumn('tour_id');
        });
    }

    public function down(): void
    {
        Schema::table('tour_reviews', function (Blueprint $table) {
            $table->foreignId('tour_id');
        });
    }
};
