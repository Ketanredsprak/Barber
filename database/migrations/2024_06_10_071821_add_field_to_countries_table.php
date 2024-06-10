<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('name_tr')->after('name_ur')->nullable();
        });

        Schema::table('states', function (Blueprint $table) {
            $table->string('name_tr')->after('name_ur')->nullable();
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->string('name_tr')->after('name_ur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('name_tr');
        });

        Schema::table('states', function (Blueprint $table) {
            $table->dropColumn('name_tr');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('name_tr');
        });
    }
};
