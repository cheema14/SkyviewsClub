<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMenuPivotTable extends Migration
{
    public function up()
    {
        Schema::create('item_menu', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id', 'item_id_fk_8598925')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id', 'menu_id_fk_8598925')->references('id')->on('menus')->onDelete('cascade');
        });
    }
}
