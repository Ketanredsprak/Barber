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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('profile_image')->after('email')->nullable();
            $table->string('phone')->unique()->after('profile_image')->nullable();
            $table->integer('otp')->after('phone')->nullable();
            $table->integer('user_type')->after('phone')->default(4)->comment('1 Admin,2 Sub Admin,3 Barber,4 Customer');
            $table->longText('token')->after("password")->comment('for login generate token by passport')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('profile_image');
            $table->dropColumn('phone');
            $table->dropColumn('otp');
            $table->dropColumn('user_type');
            $table->dropColumn('token');
        });
    }
};
