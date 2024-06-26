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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0)->comment("0 => Main Service,1,2 etc => Sub Service");
            $table->string('service_name_en')->nullable();
            $table->string('service_name_ar')->nullable();
            $table->string('service_name_ur')->nullable();
            $table->string('service_name_tr')->nullable();
            $table->string('service_image')->nullable();
            $table->string('is_special_service')->default(0)->comment("0 => Normal Service,1 => Special Service");
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
        Schema::dropIfExists('services');
    }
};
