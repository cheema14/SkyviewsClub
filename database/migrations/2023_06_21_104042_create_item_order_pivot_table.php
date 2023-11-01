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
        Schema::create('item_order', function (Blueprint $table) {
            $table->float('price', 15, 2);
            $table->float('discount', 15, 2)->nullable();
            $table->integer('quantity');
            $table->longText('content')->nullable();
            $table->foreignId('order_id');
            $table->foreignId('item_id');

        });
    }
};
