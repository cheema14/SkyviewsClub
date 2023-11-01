<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSportItemTypesTable extends Migration
{
    public function up()
    {
        Schema::table('sport_item_types', function (Blueprint $table) {
            $table->unsignedBigInteger('division_id')->nullable();
            $table->foreign('division_id', 'division_fk_9019259')->references('id')->on('sports_divisions');
        });
    }
}
