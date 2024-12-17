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
        Schema::create('room_category_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_room_category_id')->nullable();
            $table->foreign('booking_room_category_id', 'booking_room_category_fk_9065329')->references('id')->on('booking_categories');
            $table->unsignedBigInteger('room_category_id')->nullable();
            $table->foreign('room_category_id', 'room_category_fk_9065329')->references('id')->on('room_categories');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->foreign('room_id', 'room_id_fk_9065329')->references('id')->on('rooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_category_charges');
    }
};
