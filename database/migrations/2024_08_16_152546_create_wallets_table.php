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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->double('amount', 10, 2);
            $table->enum(
                'type',
                ['credit', 'debit']
            )->default('credit');
            $table->date('expiry_date');
            $table->integer('status')->default('0')->comment('0 point avalible,1 point expiry');
            $table->string('credit_type')->default('booking')->comment('booking,refarral');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
