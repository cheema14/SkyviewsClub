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
        Schema::create('menu_menu_item_category', function (Blueprint $table) {
            $table->foreignId('menu_item_category_id')->constrained('menu_item_categories');
            $table->foreignId('menu_id')->constrained('menus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
