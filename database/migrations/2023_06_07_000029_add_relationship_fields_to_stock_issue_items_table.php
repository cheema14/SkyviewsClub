<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStockIssueItemsTable extends Migration
{
    public function up()
    {
        Schema::table('stock_issue_items', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id', 'item_fk_8593428')->references('id')->on('store_items');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_8593429')->references('id')->on('units');
            $table->unsignedBigInteger('stock_issue_id')->nullable();
            $table->foreign('stock_issue_id', 'stock_issue_fk_8595170')->references('id')->on('stock_issues');
        });
    }
}
