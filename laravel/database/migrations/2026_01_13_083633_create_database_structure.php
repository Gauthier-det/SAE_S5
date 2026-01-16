<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SAN_ADDRESSES
        Schema::create('SAN_ADDRESSES', function (Blueprint $table) {
            $table->bigIncrements('ADD_ID');
            $table->bigInteger('ADD_POSTAL_CODE');
            $table->string('ADD_CITY', 255);
            $table->string('ADD_STREET_NAME', 255)->nullable();
            $table->string('ADD_STREET_NUMBER', 8)->nullable();
        });

        // SAN_CATEGORIES
        Schema::create('SAN_CATEGORIES', function (Blueprint $table) {
            $table->increments('CAT_ID');
            $table->string('CAT_LABEL', 32);
        });

        // SAN_ROLES
        Schema::create('SAN_ROLES', function (Blueprint $table) {
            $table->increments('ROL_ID');
            $table->string('ROL_NAME', 255);
        });

        // SAN_USERS
        Schema::create('SAN_USERS', function (Blueprint $table) {
            $table->increments('USE_ID');
            $table->unsignedBigInteger('ADD_ID')->nullable();
            $table->unsignedInteger('CLU_ID')->nullable();
            $table->string('USE_MAIL', 255);
            $table->string('USE_PASSWORD', 255);
            $table->string('USE_NAME', 255);
            $table->string('USE_LAST_NAME', 255);
            $table->string('USE_GENDER', 16);
            $table->date('USE_BIRTHDATE')->nullable();
            $table->string('USE_PHONE_NUMBER', 255)->nullable();
            $table->integer('USE_LICENCE_NUMBER')->nullable();
            $table->date('USE_MEMBERSHIP_DATE')->nullable();
            $table->date('USE_VALIDITY')->nullable();

            $table->index('CLU_ID', 'I_FK_SAN_USERS_SAN_CLUBS');

            // SET NULL because address is optional
            $table->foreign('ADD_ID')->references('ADD_ID')->on('SAN_ADDRESSES')->onDelete('set null');
        });

        // SAN_CLUBS
        Schema::create('SAN_CLUBS', function (Blueprint $table) {
            $table->increments('CLU_ID');
            $table->unsignedInteger('USE_ID');
            $table->unsignedBigInteger('ADD_ID');
            $table->string('CLU_NAME', 255);
            $table->string('CLU_PHONE_NUMBER', 255)->nullable();

            $table->index('USE_ID', 'I_FK_SAN_CLUBS_SAN_USERS');
            $table->index('ADD_ID', 'I_FK_SAN_CLUBS_SAN_ADDRESSES');

            // CASCADE: if the manager user is deleted, delete the club
            $table->foreign('USE_ID')->references('USE_ID')->on('SAN_USERS')->onDelete('cascade');
            // RESTRICT: prevent deletion of address used by a club
            $table->foreign('ADD_ID')->references('ADD_ID')->on('SAN_ADDRESSES')->onDelete('restrict');
        });

        // Add CLU_ID constraint to SAN_USERS after SAN_CLUBS creation
        Schema::table('SAN_USERS', function (Blueprint $table) {
            // SET NULL because club membership is optional
            $table->foreign('CLU_ID')->references('CLU_ID')->on('SAN_CLUBS')->onDelete('set null');
        });

        // SAN_TEAMS
        Schema::create('SAN_TEAMS', function (Blueprint $table) {
            $table->increments('TEA_ID');
            $table->unsignedInteger('USE_ID');
            $table->string('TEA_NAME', 255);
            $table->string('TEA_IMAGE', 1023)->nullable();

            $table->index('USE_ID', 'I_FK_SAN_TEAMS_SAN_USERS');
            // CASCADE: if the creator is deleted, delete the team
            $table->foreign('USE_ID')->references('USE_ID')->on('SAN_USERS')->onDelete('cascade');
        });

        // SAN_RAIDS
        Schema::create('SAN_RAIDS', function (Blueprint $table) {
            $table->increments('RAI_ID');
            $table->unsignedInteger('CLU_ID');
            $table->unsignedBigInteger('ADD_ID');
            $table->unsignedInteger('USE_ID');
            $table->unsignedBigInteger('RAI_NB_RACES');
            $table->string('RAI_NAME', 255);
            $table->string('RAI_MAIL', 255)->nullable();
            $table->string('RAI_PHONE_NUMBER', 255)->nullable();
            $table->string('RAI_WEB_SITE', 255)->nullable();
            $table->string('RAI_IMAGE', 1023)->nullable();
            $table->dateTime('RAI_TIME_START');
            $table->dateTime('RAI_TIME_END');
            $table->dateTime('RAI_REGISTRATION_START');
            $table->dateTime('RAI_REGISTRATION_END');

            $table->index('CLU_ID', 'I_FK_SAN_RAIDS_SAN_CLUBS');
            $table->index('ADD_ID', 'I_FK_SAN_RAIDS_SAN_ADDRESSES');
            $table->index('USE_ID', 'I_FK_SAN_RAIDS_SAN_USERS');

            // CASCADE: if the club is deleted, delete its raids
            $table->foreign('CLU_ID')->references('CLU_ID')->on('SAN_CLUBS')->onDelete('cascade');
            // RESTRICT: prevent deletion of address in use
            $table->foreign('ADD_ID')->references('ADD_ID')->on('SAN_ADDRESSES')->onDelete('restrict');
            // CASCADE: if the manager is deleted, delete the raid
            $table->foreign('USE_ID')->references('USE_ID')->on('SAN_USERS')->onDelete('cascade');
        });

        // SAN_RACES
        Schema::create('SAN_RACES', function (Blueprint $table) {
            $table->increments('RAC_ID');
            $table->unsignedInteger('USE_ID');
            $table->unsignedInteger('RAI_ID');
            $table->string('RAC_NAME', 255);
            $table->dateTime('RAC_TIME_START');
            $table->dateTime('RAC_TIME_END');
            $table->string('RAC_GENDER', 16);
            $table->string('RAC_TYPE', 255);
            $table->string('RAC_DIFFICULTY', 255);
            $table->bigInteger('RAC_MIN_PARTICIPANTS');
            $table->bigInteger('RAC_MAX_PARTICIPANTS');
            $table->bigInteger('RAC_MIN_TEAMS');
            $table->bigInteger('RAC_MAX_TEAMS');
            $table->bigInteger('RAC_MIN_TEAM_MEMBERS');
            $table->bigInteger('RAC_MAX_TEAM_MEMBERS');
            $table->bigInteger('RAC_AGE_MIN');
            $table->bigInteger('RAC_AGE_MIDDLE');
            $table->bigInteger('RAC_AGE_MAX');
            $table->integer('RAC_CHIP_MANDATORY');

            $table->index('USE_ID', 'I_FK_SAN_RACES_SAN_USERS');
            $table->index('RAI_ID', 'I_FK_SAN_RACES_SAN_RAIDS');

            // CASCADE: if the creator is deleted, delete the race
            $table->foreign('USE_ID')->references('USE_ID')->on('SAN_USERS')->onDelete('cascade');
            // CASCADE: if the raid is deleted, delete its races
            $table->foreign('RAI_ID')->references('RAI_ID')->on('SAN_RAIDS')->onDelete('cascade');
        });

        // SAN_USERS_TEAMS (pivot table)
        Schema::create('SAN_USERS_TEAMS', function (Blueprint $table) {
            $table->unsignedInteger('USE_ID');
            $table->unsignedInteger('TEA_ID');
            $table->primary(['USE_ID', 'TEA_ID']);

            $table->index('USE_ID', 'I_FK_SAN_USERS_TEAMS_SAN_USERS');
            $table->index('TEA_ID', 'I_FK_SAN_USERS_TEAMS_SAN_TEAMS');

            // CASCADE: if user is deleted, remove team memberships
            $table->foreign('USE_ID')->references('USE_ID')->on('SAN_USERS')->onDelete('cascade');
            // CASCADE: if team is deleted, remove all members
            $table->foreign('TEA_ID')->references('TEA_ID')->on('SAN_TEAMS')->onDelete('cascade');
        });

        // SAN_TEAMS_RACES (pivot table)
        Schema::create('SAN_TEAMS_RACES', function (Blueprint $table) {
            $table->unsignedInteger('TEA_ID');
            $table->unsignedInteger('RAC_ID');
            $table->time('TER_TIME')->nullable();
            $table->integer('TER_POINTS')->nullable();
            $table->integer('TER_IS_VALID')->nullable();
            $table->integer('TER_RACE_NUMBER');
            $table->integer('TER_RANK')->nullable();
            $table->integer('TER_BONUS_POINTS')->nullable();
            $table->primary(['TEA_ID', 'RAC_ID']);

            $table->index('TEA_ID', 'I_FK_SAN_TEAMS_RACES_SAN_TEAMS');
            $table->index('RAC_ID', 'I_FK_SAN_TEAMS_RACES_SAN_RACES');

            // CASCADE: if team is deleted, remove registrations
            $table->foreign('TEA_ID')->references('TEA_ID')->on('SAN_TEAMS')->onDelete('cascade');
            // CASCADE: if race is deleted, remove all registrations
            $table->foreign('RAC_ID')->references('RAC_ID')->on('SAN_RACES')->onDelete('cascade');
        });

        // SAN_ROLES_USERS (pivot table)
        Schema::create('SAN_ROLES_USERS', function (Blueprint $table) {
            $table->unsignedInteger('USE_ID');
            $table->unsignedInteger('ROL_ID');
            $table->primary(['USE_ID', 'ROL_ID']);

            $table->index('USE_ID', 'I_FK_SAN_ROLES_USERS_SAN_USERS');
            $table->index('ROL_ID', 'I_FK_SAN_ROLES_USERS_SAN_ROLES');

            // CASCADE: if user is deleted, remove their roles
            $table->foreign('USE_ID')->references('USE_ID')->on('SAN_USERS')->onDelete('cascade');
            // CASCADE: if role is deleted, remove all users with that role
            $table->foreign('ROL_ID')->references('ROL_ID')->on('SAN_ROLES')->onDelete('cascade');
        });

        // SAN_CATEGORIES_RACES (pivot table)
        Schema::create('SAN_CATEGORIES_RACES', function (Blueprint $table) {
            $table->unsignedInteger('RAC_ID');
            $table->unsignedInteger('CAT_ID');
            $table->decimal('CAR_PRICE', 10, 2);
            $table->primary(['RAC_ID', 'CAT_ID']);

            $table->index('RAC_ID', 'I_FK_SAN_CATEGORIES_RACES_SAN_RACES');
            $table->index('CAT_ID', 'I_FK_SAN_CATEGORIES_RACES_SAN_CATEGORIES');

            // CASCADE: if race is deleted, remove category prices
            $table->foreign('RAC_ID')->references('RAC_ID')->on('SAN_RACES')->onDelete('cascade');
            // CASCADE: if category is deleted, remove all prices
            $table->foreign('CAT_ID')->references('CAT_ID')->on('SAN_CATEGORIES')->onDelete('cascade');
        });

        // SAN_USERS_RACES (pivot table)
        Schema::create('SAN_USERS_RACES', function (Blueprint $table) {
            $table->unsignedInteger('USE_ID');
            $table->unsignedInteger('RAC_ID');
            $table->decimal('USR_TIME', 10, 2)->nullable();
            $table->integer('USR_CHIP_NUMBER')->nullable();
            $table->string('USR_PPS_FORM', 255)->nullable();
            $table->primary(['USE_ID', 'RAC_ID']);

            $table->index('USE_ID', 'I_FK_SAN_USERS_RACES_SAN_USERS');
            $table->index('RAC_ID', 'I_FK_SAN_USERS_RACES_SAN_RACES');

            // CASCADE: if user is deleted, remove their registrations
            $table->foreign('USE_ID')->references('USE_ID')->on('SAN_USERS')->onDelete('cascade');
            // CASCADE: if race is deleted, remove all registrations
            $table->foreign('RAC_ID')->references('RAC_ID')->on('SAN_RACES')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');

        Schema::dropIfExists('SAN_USERS_RACES');
        Schema::dropIfExists('SAN_CATEGORIES_RACES');
        Schema::dropIfExists('SAN_ROLES_USERS');
        Schema::dropIfExists('SAN_TEAMS_RACES');
        Schema::dropIfExists('SAN_USERS_TEAMS');
        Schema::dropIfExists('SAN_RACES');
        Schema::dropIfExists('SAN_RAIDS');
        Schema::dropIfExists('SAN_TEAMS');
        Schema::dropIfExists('SAN_USERS');
        Schema::dropIfExists('SAN_CLUBS');
        Schema::dropIfExists('SAN_ROLES');
        Schema::dropIfExists('SAN_CATEGORIES');
        Schema::dropIfExists('SAN_ADDRESSES');

        DB::statement('PRAGMA foreign_keys = ON');
    }

};
