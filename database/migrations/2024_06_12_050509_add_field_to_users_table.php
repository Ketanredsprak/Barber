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
            $table->string("first_name")->after("id");
            $table->string("last_name")->after("first_name");
            $table->string("gender")->after("last_name")->nullable();
            $table->string("referral_code")->after("gender");
            $table->integer("country_code")->after("referral_code")->default(0);
            $table->string("nationality")->after("phone")->nullable();
            $table->string("iqama_no")->after("nationality")->nullable();
            $table->string("health_license")->after("iqama_no")->comment("Health license file name")->nullable();
            $table->string("store_registration")->after("health_license")->comment("Store registration file name")->nullable();
            $table->date("expiration_date")->after("store_registration")->comment("date")->nullable();
            $table->string("salon_name")->after("expiration_date")->comment("string")->nullable();
            $table->string("location")->after("salon_name")->comment("string")->nullable();
            $table->string("country_name")->after("location")->comment("string")->nullable();
            $table->string("state_name")->after("country_name")->comment("string")->nullable();
            $table->string("city_name")->after("state_name")->comment("string")->nullable();
            $table->string("about_you")->after("city_name")->comment("string")->nullable();
            $table->string("latitude")->after("about_you")->comment("string")->nullable();
            $table->string("longitude")->after("latitude")->comment("string")->nullable();
            $table->integer('register_type')->after("user_type")->default(0)->comment("1 => App,2 => Web");
            $table->integer('register_method')->after("register_type")->default(0)->comment("1 => System,2 => Facebook,3 => Google, 4 => Apple");
            $table->enum('is_approved',['0','1','2'])->after("register_method")->default(0)->comment("1 => Pending,2 => Approved,3 => Block");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('gender');
            $table->dropColumn('referral_code');
            $table->dropColumn('country_code');
            $table->dropColumn('nationality');
            $table->dropColumn('iqama_no');
            $table->dropColumn('health_license');
            $table->dropColumn('store_registration');
            $table->dropColumn('expiration_date');
            $table->dropColumn('salon_name');
            $table->dropColumn('location');
            $table->dropColumn('country_name');
            $table->dropColumn('state_name');
            $table->dropColumn('city_name');
            $table->dropColumn('about_you');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('register_type');
            $table->dropColumn('register_method');
            $table->dropColumn('is_approved');
        });
    }
};
