<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrItemDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('gr_item_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->integer('unit_rate');
            $table->integer('total_amount');
            $table->date('expiry_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
