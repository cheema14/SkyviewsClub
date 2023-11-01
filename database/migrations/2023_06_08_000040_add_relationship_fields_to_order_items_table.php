<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id', 'order_fk_8599796')->references('id')->on('orders');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id', 'item_fk_8599797')->references('id')->on('items');
        });
    }
}
