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
        Schema::table('bills', function (Blueprint $table) {
            $table->decimal('snooker_fee')->nullable();
            $table->decimal('proshop_fee')->nullable();
            $table->decimal('golf_simulator')->nullable();
            $table->decimal('golf_locker')->nullable();
            $table->decimal('golf_course')->nullable();
            $table->decimal('golf_cart_fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
