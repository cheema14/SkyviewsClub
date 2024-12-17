<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_room_category_id')->nullable();
            $table->foreign('booking_room_category_id', 'booking_room_category_fk_9168450')->references('id')->on('booking_categories');
            $table->unsignedBigInteger('room_category_id')->nullable();
            $table->foreign('room_category_id', 'room_category_fk_9168451')->references('id')->on('room_categories');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->foreign('room_id', 'room_id_fk_9168452')->references('id')->on('rooms');
            $table->unsignedBigInteger('room_bookings_member_id')->nullable();
            $table->foreign('room_bookings_member_id', 'room_id_fk_9168453')->references('id')->on('members');
            $table->string('checkin_date')->nullable();
            $table->string('checkout_date')->nullable();
            $table->integer('price_at_booking_time')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
    }
};
