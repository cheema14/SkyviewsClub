<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportsBillingsTable extends Migration
{
    public function up()
    {
        Schema::create('sports_billings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('member_name')->nullable();
            $table->string('non_member_name')->nullable();
            $table->date('bill_date');
            $table->string('bill_number')->nullable();
            $table->string('remarks')->nullable();
            $table->string('ref_club')->nullable();
            $table->string('club_id_ref')->nullable();
            $table->string('tee_off')->nullable();
            $table->string('holes')->nullable();
            $table->string('caddy')->nullable();
            $table->string('temp_mbr')->nullable();
            $table->string('temp_caddy')->nullable();
            $table->string('pay_mode')->nullable();
            $table->integer('gross_total')->nullable();
            $table->integer('total_payable')->nullable();
            $table->float('bank_charges', 4, 2)->nullable();
            $table->float('net_pay', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
