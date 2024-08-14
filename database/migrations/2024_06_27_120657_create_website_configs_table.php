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
        Schema::create('website_configs', function (Blueprint $table) {
            $table->id();
            $table->string("header_logo");
            $table->string("footer_logo");
            $table->string("location_en");
            $table->string("location_ar");
            $table->string("location_ur");
            $table->string("location_tr");
            $table->string("website_link");
            $table->string("phone");
            $table->string("whatsapp");
            $table->string("email");
            $table->string("facebook_link");
            $table->string("twitter_link");
            $table->string("linkedin_link");
            $table->string("youtube_link");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_configs');
    }
};
