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
        Schema::create('discounted_membership_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->date('implemented_from')->nullable();
            $table->integer('no_of_months')->nullable();
            $table->integer('remaining_months')->nullable();
            $table->double('monthly_subscription_revised')->nullable();
            $table->tinyInteger('is_active')->default('0')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounted_membership_fees');
    }
};
