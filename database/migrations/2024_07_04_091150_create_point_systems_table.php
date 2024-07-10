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
        Schema::create('point_systems', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("per_booking_points");
            $table->bigInteger("per_active_referral_points");
            $table->bigInteger("how_many_point_equal_sr");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_systems');
    }
};
