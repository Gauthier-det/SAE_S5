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
        Schema::table('SAN_RACES', function (Blueprint $table) {
            $table->decimal('RAC_MEAL_PRICE', 10, 2)->nullable()->after('RAC_CHIP_MANDATORY');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('SAN_RACES', function (Blueprint $table) {
            $table->dropColumn('RAC_MEAL_PRICE');
        });
    }
};
