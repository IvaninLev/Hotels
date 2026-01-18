<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->foreignIdFor(\App\Models\Country::class)->after('id')->constrained();
            $table->foreignIdFor(\App\Models\City::class)->after('country_id')->constrained();

        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign('hotels_country_id_foreign');
            $table->dropForeign('hotels_city_id_foreign');
            $table->dropColumn('country_id');
            $table->dropColumn('city_id');
            $table->string('country');
            $table->string('city');
        });
    }
};
