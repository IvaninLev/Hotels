<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->dropColumn('beds');
            $table->dropColumn('price');
            $table->dropColumn('area');
        });
    }

    public function down(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->integer('beds');
            $table->decimal('price');
            $table->integer('area');
        });
    }
};
