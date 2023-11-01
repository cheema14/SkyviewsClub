<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportItemTypesTable extends Migration
{
    public function up()
    {
        Schema::create('sport_item_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
