<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->float('item_discount', 15, 2)->nullable();
            $table->float('sub_total', 15, 2)->nullable();
            $table->float('tax', 15, 2)->nullable();
            $table->float('total', 15, 2)->nullable();
            $table->string('promo')->nullable();
            $table->float('discount', 15, 2)->nullable();
            $table->float('grand_total', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
