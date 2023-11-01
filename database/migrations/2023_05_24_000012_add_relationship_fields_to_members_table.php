<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMembersTable extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->foreign('designation_id', 'designation_fk_8526069')->references('id')->on('designations');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_8526098')->references('id')->on('departments');
            $table->unsignedBigInteger('membership_category_id')->nullable();
            $table->foreign('membership_category_id', 'membership_category_fk_8526144')->references('id')->on('membership_categories');
            $table->unsignedBigInteger('membership_type_id')->nullable();
            $table->foreign('membership_type_id', 'membership_type_fk_8526145')->references('id')->on('membership_types');
        });
    }
}
