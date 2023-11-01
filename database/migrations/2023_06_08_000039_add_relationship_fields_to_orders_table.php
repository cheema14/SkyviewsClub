<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_8599684')->references('id')->on('users');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id', 'member_fk_8599685')->references('id')->on('members');
        });
    }
}
