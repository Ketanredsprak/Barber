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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('transaction_id')->default(0);
            $table->integer('subscription_id')->default(0);
            $table->string('subscription_duration')->nullable()->comment("subscription duration in day");
            $table->enum('status',['active','expired','cancelled','inactive']);
            $table->integer('availble_booking');
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
