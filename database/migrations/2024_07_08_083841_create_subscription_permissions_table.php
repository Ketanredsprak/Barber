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
        Schema::create('subscription_permissions', function (Blueprint $table) {
            $table->id();
            $table->string("permission_name");
            $table->string("permission_for_user")->nullable();
            $table->text("permission_detail")->nullable();
            $table->integer("basic")->default(0)->comment("1 => permission,0 => not permission");
            $table->integer("silver")->default(0)->comment("1 => permission,0 => not permission");
            $table->integer("bronz")->default(0)->comment("1 => permission,0 => not permission");
            $table->integer("gold")->default(0)->comment("1 => permission,0 => not permission");
            $table->text("subscription_array")->nullable();
            $table->integer('is_input_box')->default(0)->comment("1 => provice input,0 => no input");
            $table->text("basic_input_value")->nullable();
            $table->text("silver_input_value")->nullable();
            $table->text("bronz_input_value")->nullable();
            $table->text("gold_input_value")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_permissions');
    }
};
