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
        Schema::create('wait_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->integer('any_date')->nullable();
            $table->integer('any_time')->nullable();
            $table->integer('select_date')->nullable();
            $table->date('selected_date')->nullable();
            $table->integer('select_time')->nullable();
            $table->time('selected_time')->nullable();
            $table->integer('select_time_range')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->integer('select_date_range')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wait_lists');
    }
};
