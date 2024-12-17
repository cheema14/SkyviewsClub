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
        Schema::create('employees_dependents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); //
            $table->string('cnic')->nullable();
            $table->string('cell_no')->nullable();
            $table->date('marriage_date')->nullable();
            $table->string('marriage_place')->nullable();
            $table->string('address')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('cast')->nullable();
            // Now fields for children
            $table->string('gender')->nullable(); 
            $table->string('profession')->nullable(); 
            $table->string('child_address')->nullable();
            $table->foreignId('employee_id')->constrained('employees'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_dependents');
    }
};
