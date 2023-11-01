<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodReceiptsTable extends Migration
{
    public function up()
    {
        Schema::create('good_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gr_number')->unique();
            $table->date('gr_date');
            $table->string('pay_type');
            $table->longText('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
