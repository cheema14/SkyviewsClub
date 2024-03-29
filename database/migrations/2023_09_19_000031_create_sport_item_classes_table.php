<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportItemClassesTable extends Migration
{
    public function up()
    {
        Schema::create('sport_item_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_class')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
