<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockIssuesTable extends Migration
{
    public function up()
    {
        Schema::create('stock_issues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('issue_no');
            $table->date('issue_date');
            $table->longText('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
