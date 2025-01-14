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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->date("store_registration_expiration_date")->after('health_license_expiration_date')->comment("date")->nullable();
            $table->date("iqama_no_expiration_date")->after('store_registration_expiration_date')->comment("date")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('store_registration_expiration_date');
            $table->dropColumn('iqama_no_expiration_date');
        });
    }
};
