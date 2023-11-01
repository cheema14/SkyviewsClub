<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDependentsTable extends Migration
{
    public function up()
    {
        Schema::create('dependents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('dob')->nullable();
            $table->string('relation');
            $table->string('occupation')->nullable();
            $table->string('nationality')->nullable();
            $table->string('golf_hcap')->nullable();
            $table->string('allow_credit')->nullable();
            $table->foreignId('member_id')->constrained('members');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
