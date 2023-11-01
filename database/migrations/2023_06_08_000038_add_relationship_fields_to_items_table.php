<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToItemsTable extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_item_category_id')->nullable();
            $table->foreign('menu_item_category_id', 'menu_item_category_fk_8598926')->references('id')->on('menu_item_categories');
        });
    }
}
