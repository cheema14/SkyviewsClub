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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->decimal('balance_bfcr')->nullable();
            $table->decimal('membership_installment')->nullable();
            $table->decimal('monthly_subscription')->nullable();
            $table->decimal('restaurant_fee')->nullable();
            $table->decimal('cafe_fee')->nullable();
            $table->decimal('caddies_fee')->nullable();
            $table->decimal('club_golf_match_fee')->nullable();
            $table->decimal('locker_fee')->nullable();
            $table->decimal('pga_subscription_fee')->nullable();
            $table->decimal('practice_range_coaching_fee')->nullable();
            $table->decimal('fee')->nullable();
            $table->decimal('card_fee')->nullable();
            $table->decimal('cart_fee')->nullable();
            $table->decimal('total')->nullable();
            $table->string('cheque_no',150)->nullable();
            $table->date('bill_month')->nullable();
            $table->decimal('credit_amount')->nullable();
            $table->decimal('net_balance_payable')->nullable();
            $table->string('status',155)->default('Pending');
            $table->string('remarks')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
