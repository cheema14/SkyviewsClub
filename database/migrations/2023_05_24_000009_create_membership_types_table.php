<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipTypesTable extends Migration
{
    public function up()
    {
        Schema::create('membership_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('effective_from')->nullable();
            $table->decimal('subscription_fee', 15, 2)->nullable();
            $table->decimal('security_fee', 15, 2)->nullable();
            $table->decimal('monthly_fee', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
