<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSportItemClassesTable extends Migration
{
    public function up()
    {
        Schema::table('sport_item_classes', function (Blueprint $table) {
            $table->unsignedBigInteger('item_type_id')->nullable();
            $table->foreign('item_type_id', 'item_type_fk_9019271')->references('id')->on('sport_item_types');
        });
    }
}
