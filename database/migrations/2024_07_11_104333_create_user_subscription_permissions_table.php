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
        Schema::create('user_subscription_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('subscription_id')->default(0);
            $table->integer('permission_id')->default(0);
            $table->string('permission_name')->comment("permission_name")->nullable();
            $table->integer('is_input_box')->default(0);
            $table->string('input_value')->comment("condition")->nullable();
            $table->enum('status',['active','expired','cancelled','inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscription_permissions');
    }
};
