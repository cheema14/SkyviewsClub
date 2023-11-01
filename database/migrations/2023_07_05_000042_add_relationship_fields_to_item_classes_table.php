<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToItemClassesTable extends Migration
{
    public function up()
    {
        Schema::table('item_classes', function (Blueprint $table) {
            $table->unsignedBigInteger('item_type_id')->nullable();
            $table->foreign('item_type_id', 'item_type_fk_8713288')->references('id')->on('item_types');
        });
    }
}
