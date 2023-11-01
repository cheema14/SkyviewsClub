<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportBillingItemsTable extends Migration
{
    public function up()
    {
        Schema::create('sport_billing_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->integer('rate');
            $table->integer('amount');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
