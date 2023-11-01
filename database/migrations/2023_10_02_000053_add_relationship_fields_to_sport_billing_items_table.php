<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSportBillingItemsTable extends Migration
{
    public function up()
    {
        Schema::table('sport_billing_items', function (Blueprint $table) {
            $table->unsignedBigInteger('billing_division_id')->nullable();
            $table->foreign('billing_division_id', 'billing_division_fk_9065329')->references('id')->on('sports_divisions');
            $table->unsignedBigInteger('billing_item_type_id')->nullable();
            $table->foreign('billing_item_type_id', 'billing_item_type_fk_9065330')->references('id')->on('sport_item_types');
            $table->unsignedBigInteger('billing_item_class_id')->nullable();
            $table->foreign('billing_item_class_id', 'billing_item_class_fk_9065331')->references('id')->on('sport_item_classes');
            $table->unsignedBigInteger('billing_item_name_id')->nullable();
            $table->foreign('billing_item_name_id', 'billing_item_name_fk_9065332')->references('id')->on('sport_item_names');
            $table->unsignedBigInteger('billing_issue_item_id')->nullable();
            $table->foreign('billing_issue_item_id', 'billing_issue_item_fk_9065336')->references('id')->on('sports_billings');
        });
    }
}
