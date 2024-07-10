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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_name_en')->nullable();
            $table->string('subscription_name_ar')->nullable();
            $table->string('subscription_name_ur')->nullable();
            $table->string('subscription_name_tr')->nullable();
            $table->text('subscription_detail_en')->nullable();
            $table->text('subscription_detail_ar')->nullable();
            $table->text('subscription_detail_ur')->nullable();
            $table->text('subscription_detail_tr')->nullable();
            $table->string('number_of_booking')->nullable();
            $table->string('price')->nullable();
            $table->string('duration_in_days')->nullable();
            $table->integer('status')->default(0);
            $table->string('subscription_type')->comment("barber,customer");
            $table->string("is_delete")->default(0)->comment("1 => data delete,0 => data not delete");
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
