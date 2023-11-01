<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportsDivisionsTable extends Migration
{
    public function up()
    {
        Schema::create('sports_divisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('division')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
