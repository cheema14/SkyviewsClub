<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockIssueItemsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_issue_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lot_no');
            $table->integer('stock_required');
            $table->integer('issued_qty');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
