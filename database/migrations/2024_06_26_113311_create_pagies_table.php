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
        Schema::create('pagies', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('page_name_en');
            $table->string('page_name_ar');
            $table->string('page_name_ur');
            $table->string('page_name_tr');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagies');
    }
};
