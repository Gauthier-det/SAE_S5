<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('SAN_TEAMS_RACES', function (Blueprint $table) {
            $table->integer('TER_RANK')->nullable();
            $table->integer('TER_BONUS_POINTS')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('SAN_TEAMS_RACES', function (Blueprint $table) {
            $table->dropColumn(['TER_RANK', 'TER_BONUS_POINTS']);
        });
    }
};
