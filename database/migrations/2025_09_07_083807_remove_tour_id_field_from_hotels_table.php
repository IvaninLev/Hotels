<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign('hotels_tour_id_foreign');
            $table->dropColumn('tour_id');
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Tour::class)->constrained();
        });
    }
};
