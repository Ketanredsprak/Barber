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
        Schema::create('meta_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page_name')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_title_ur')->nullable();
            $table->string('meta_title_tr')->nullable();
            $table->string('meta_content_en')->nullable();
            $table->string('meta_content_ar')->nullable();
            $table->string('meta_content_ur')->nullable();
            $table->string('meta_content_tr')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meta_contents');
    }
};
