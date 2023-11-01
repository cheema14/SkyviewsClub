<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStoreItemsTable extends Migration
{
    public function up()
    {
        Schema::table('store_items', function (Blueprint $table) {
            $table->unsignedBigInteger('store_id')->nullable();
            $table->foreign('store_id', 'store_fk_8588014')->references('id')->on('stores');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id', 'item_fk_8588015')->references('id')->on('item_types');
        });
    }
}
