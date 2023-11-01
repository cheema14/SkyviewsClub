<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToGrItemDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('gr_item_details', function (Blueprint $table) {
            $table->unsignedBigInteger('gr_id')->nullable();
            $table->foreign('gr_id', 'gr_fk_8588356')->references('id')->on('good_receipts');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id', 'item_fk_8588349')->references('id')->on('store_items');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_8588350')->references('id')->on('units');
        });
    }
}
