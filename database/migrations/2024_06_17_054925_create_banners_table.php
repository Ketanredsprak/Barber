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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_ur')->nullable();
            $table->string('title_tr')->nullable();
            $table->string('content_en')->nullable();
            $table->string('content_ar')->nullable();
            $table->string('content_ur')->nullable();
            $table->string('content_tr')->nullable();
            $table->integer('barber_id')->default(0)->nullable();
            $table->string('banner_image')->nullable();
            $table->integer('status')->default(0);
            $table->integer('is_delete')->default(0)->comment("1 => data delete,0 => data not delete");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
