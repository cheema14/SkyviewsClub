<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSportItemNamesTable extends Migration
{
    public function up()
    {
        Schema::table('sport_item_names', function (Blueprint $table) {
            $table->unsignedBigInteger('item_class_id')->nullable();
            $table->foreign('item_class_id', 'item_class_fk_9019283')->references('id')->on('sport_item_classes');
        });
    }
}
