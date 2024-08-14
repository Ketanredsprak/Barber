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
        Schema::create('barber_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer("barber_id")->default(0);
            $table->integer("monday_is_holiday")->default(0)->comment("0 = working,1 holiday");
            $table->time("monday_start_time")->nullable();
            $table->time("monday_end_time")->nullable();
            $table->integer("tuesday_is_holiday")->default(0)->comment("0 = working,1 holiday");
            $table->time("tuesday_start_time")->nullable();
            $table->time("tuesday_end_time")->nullable();
            $table->integer("wednesday_is_holiday")->default(0)->comment("0 = working,1 holiday");
            $table->time("wednesday_start_time")->nullable();
            $table->time("wednesday_end_time")->nullable();
            $table->integer("thursday_is_holiday")->default(0)->comment("0 = working,1 holiday");
            $table->time("thursday_start_time")->nullable();
            $table->time("thursday_end_time")->nullable();
            $table->integer("friday_is_holiday")->default(0)->comment("0 = working,1 holiday");
            $table->time("friday_start_time")->nullable();
            $table->time("friday_end_time")->nullable();
            $table->integer("saturday_is_holiday")->default(0)->comment("0 = working,1 holiday");
            $table->time("saturday_start_time")->nullable();
            $table->time("saturday_end_time")->nullable();
            $table->integer("sunday_is_holiday")->default(0)->comment("0 = working,1 holiday");
            $table->time("sunday_start_time")->nullable();
            $table->time("sunday_end_time")->nullable();
            $table->string("slot_duration")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barber_schedules');
    }
};
