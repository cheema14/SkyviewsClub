<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('summary')->nullable();
            $table->float('price', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
