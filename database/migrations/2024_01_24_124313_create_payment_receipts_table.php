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
        Schema::create('payment_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no')->nullable();
            $table->string('receipt_date')->nullable();
            $table->string('bill_type')->nullable();
            $table->string('billing_month')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('invoice_amount')->nullable();
            $table->enum('pay_mode' , ['Cash' , 'Online' , 'Transfer','Cheque'])->nullable();
            $table->decimal('received_amount')->nullable();
            
            // Required and populated only if cheque selected 
            $table->string('cheque_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->date('cheque_date')->nullable();
            
            // Required and populated only if online deposit
            $table->string('deposit_slip_number')->nullable();
            $table->string('deposit_bank_name')->nullable();
            $table->date('deposit_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_receipts');
    }
};
