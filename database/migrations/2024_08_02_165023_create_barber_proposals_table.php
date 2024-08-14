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
        Schema::create('barber_proposals', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->nullable();
            $table->longText('slots')->nullable();
            $table->date('booking_date')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('barber_id')->nullable();
            $table->string('status')->nullable()->commnt('default->pending,accept,reject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barber_proposals');
    }
};
