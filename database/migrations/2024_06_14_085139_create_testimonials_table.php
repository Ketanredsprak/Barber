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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('name_ur')->nullable();
            $table->string('name_tr')->nullable();
            $table->string('designation_en')->nullable();
            $table->string('designation_ar')->nullable();
            $table->string('designation_ur')->nullable();
            $table->string('designation_tr')->nullable();
            $table->string('testimonial_content_en')->nullable();
            $table->string('testimonial_content_ar')->nullable();
            $table->string('testimonial_content_ur')->nullable();
            $table->string('testimonial_content_tr')->nullable();
            $table->string('testimonial_image')->nullable();
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
        Schema::dropIfExists('testimonials');
    }
};
