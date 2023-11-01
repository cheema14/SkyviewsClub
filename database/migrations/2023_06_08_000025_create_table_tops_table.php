<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTopsTable extends Migration
{
    public function up()
    {
        Schema::create('table_tops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('capacity')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
