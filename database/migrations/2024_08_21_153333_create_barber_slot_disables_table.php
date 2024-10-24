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
        Schema::create('barber_slot_disables', function (Blueprint $table) {
            $table->id();
            $table->integer('barber_id')->default(0);
            $table->enum(
                'disable_type',
                ['0','1','2']
            )->default('0')->commint('0 = manual slots disable,1 all slot disable for specific date,2 = date wise full day slots disable');
            $table->date('date')->nullable();
            $table->string('slot')->nullable();
            $table->integer('all_slots')->default(0)->comment("0 = manual slots,1 all slots disable");
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barber_slot_disables');
    }
};
