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
            $table->longText('title_en');
            $table->longText('content_en');
            $table->longText('title_ar');
            $table->longText('content_ar');
            $table->longText('title_ur');
            $table->longText('content_ur');
            $table->longText('title_tr');
            $table->longText('content_tr');
            $table->string('slug');
            $table->integer('status')->nullable()->default(0);
            $table->integer('is_delete')->nullable()->default(0);
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
