<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('flight_to');
            $table->dropColumn('flight_from');
            $table->foreignIdFor(\App\Models\Hotel::class)->constrained();
            $table->foreignIdFor(\App\Models\Airport::class)->constrained();
            $table->text('description')->after('name');
            $table->integer('duration')->after('description');
            $table->timestamp('active_from');
            $table->timestamp('active_to');

        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {

            $table->dropForeign('tours_hotel_id_foreign');
            $table->dropForeign('tours_airport_id_foreign');
            $table->dropForeignIdFor(\App\Models\Hotel::class);
            $table->dropForeignIdFor(\App\Models\Airport::class);
            $table->dropColumn('description');
            $table->dropColumn('duration');
            $table->dropColumn('active_from');
            $table->dropColumn('active_to');
            $table->string('flight_to')->nullable();
            $table->string('flight_from')->nullable();
        });
    }
};
