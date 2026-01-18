<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('hotel_key')->after('id');
            $table->json('images')->nullable()->change();
        });
        foreach (\App\Models\Hotel::all() as $hotel) {
            $hotel->hotel_key = \Illuminate\Support\Str::random(10);
            $hotel->save();
        }
        Schema::table('hotels', function (Blueprint $table) {
            $table->unique('hotel_key');
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('hotel_key');
            $table->json('images')->change();
        });
    }
};
