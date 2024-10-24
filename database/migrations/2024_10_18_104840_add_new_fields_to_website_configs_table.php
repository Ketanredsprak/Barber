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
        Schema::table('website_configs', function (Blueprint $table) {
            //
            $table->string('play_store_link')->after('youtube_link');
            $table->string('app_store_link')->after('play_store_link');
            $table->integer('km_range')->after('app_store_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_configs', function (Blueprint $table) {
            //
            $table->dropColumn('play_store_link');
            $table->dropColumn('app_store_link');
            $table->dropColumn('km_range');
        });
    }
};
