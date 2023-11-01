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
        Schema::table('members', function (Blueprint $table) {
            $table->string('organization')->nullable();
            $table->string('monthly_type')->nullable();
            $table->integer('monthly_fee')->nullable();
            $table->integer('caddy_welfare_fee')->nullable();
            $table->integer('security_fee')->nullable();
            $table->string('payment_method')->nullable();
            $table->date('membership_card_issuance')->nullable();
            $table->date('membership_card_expiry')->nullable();
            $table->string('credit_allow_dependent')->nullable();
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
