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
        Schema::table('payment_receipts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_8599049')->references('id')->on('users');
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->foreign('bill_id', 'bill_fk_8599850')->references('id')->on('bills');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id', 'member_fk_8599850')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_receipts', function (Blueprint $table) {
            //
        });
    }
};
