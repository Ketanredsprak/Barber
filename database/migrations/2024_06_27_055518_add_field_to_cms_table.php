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
        Schema::table('cms', function (Blueprint $table) {
            //
            $table->string("sub_title_en")->after("title_en")->nullable();
            $table->string("sub_title_ar")->after("title_ar")->nullable();
            $table->string("sub_title_ur")->after("title_ur")->nullable();
            $table->string("sub_title_tr")->after("title_tr")->nullable();
            $table->string("cms_image")->after("title_tr")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms', function (Blueprint $table) {
            //
            $table->dropColumn('sub_title_en');
            $table->dropColumn('sub_title_ar');
            $table->dropColumn('sub_title_ur');
            $table->dropColumn('sub_title_tr');
            $table->dropColumn('cms_image');
        });
    }
};
