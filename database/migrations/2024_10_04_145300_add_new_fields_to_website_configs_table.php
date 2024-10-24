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
            $table->string("customer_app_login_image");
            $table->string("customer_app_title_en");
            $table->string("customer_app_title_ar");
            $table->string("customer_app_title_ur");
            $table->string("customer_app_title_tr");
            $table->string("customer_app_content_en");
            $table->string("customer_app_content_ar");
            $table->string("customer_app_content_ur");
            $table->string("customer_app_content_tr");
            $table->string("barber_app_login_image");
            $table->string("barber_app_title_en");
            $table->string("barber_app_title_ar");
            $table->string("barber_app_title_ur");
            $table->string("barber_app_title_tr");
            $table->string("barber_app_content_en");
            $table->string("barber_app_content_ar");
            $table->string("barber_app_content_ur");
            $table->string("barber_app_content_tr");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_configs', function (Blueprint $table) {
            //
            $table->dropColumn('customer_app_login_image')->after("youtube_link");
            $table->dropColumn('customer_app_title_en')->after("customer_app_login_image");
            $table->dropColumn('customer_app_title_ar')->after("customer_app_title_en");
            $table->dropColumn('customer_app_title_ur')->after("customer_app_title_ar");
            $table->dropColumn('customer_app_title_tr')->after("customer_app_title_ur");
            $table->dropColumn('customer_app_content_en')->after("customer_app_title_tr");
            $table->dropColumn('customer_app_content_ar')->after("customer_app_content_en");
            $table->dropColumn('customer_app_content_ur')->after("customer_app_content_ar");
            $table->dropColumn('customer_app_content_tr')->after("customer_app_content_ur");
            $table->dropColumn('barber_app_login_image')->after("customer_app_content_tr");
            $table->dropColumn('barber_app_title_en')->after("barber_app_login_image");
            $table->dropColumn('barber_app_title_ar')->after("barber_app_title_en");
            $table->dropColumn('barber_app_title_ur')->after("barber_app_title_ar");
            $table->dropColumn('barber_app_title_tr')->after("barber_app_title_ur");
            $table->dropColumn('barber_app_content_en')->after("barber_app_title_tr");
            $table->dropColumn('barber_app_content_ar')->after("barber_app_content_en");
            $table->dropColumn('barber_app_content_ur')->after("barber_app_content_ar");
            $table->dropColumn('barber_app_content_tr')->after("barber_app_content_ur");
        });
    }
};
