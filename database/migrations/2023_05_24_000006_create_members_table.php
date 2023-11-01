<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('bps')->nullable();
            $table->string('membership_no');
            $table->string('mailing_address')->nullable();
            $table->string('telephone_off')->nullable();
            $table->string('cell_no')->nullable();
            $table->string('email_address')->nullable();
            $table->string('cnic_no');
            $table->longText('special_instructions')->nullable();
            $table->integer('pak_svc_no')->nullable();
            $table->string('husband_father_name');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('qualification')->nullable();
            $table->string('station_city')->nullable();
            $table->string('present_status')->nullable();
            $table->string('membership_status')->nullable();
            $table->string('tel_res')->nullable();
            $table->date('date_of_membership')->nullable();
            $table->string('golf_h_cap')->nullable();
            $table->string('nationality')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('membership_fee')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
