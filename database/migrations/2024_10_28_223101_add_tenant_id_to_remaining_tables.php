<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tables to update.
     *
     * @var array
     */
    protected $tables = [
        // 'activity_log',
        // 'bills',
        // 'booking_categories',
        // 'departments',
        // 'dependents',
        // 'designations',
        // 'discounted_membership_fees',
        // 'employees',
        // 'employees_dependents',
        // 'good_receipts',
        // 'gr_item_details',
        // 'item_classes',
        // 'room_bookings',
        // 'room_categories',
        // 'room_category_charges',
        // 'rooms',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // foreach ($this->tables as $table) {
        //     Schema::table($table, function (Blueprint $table) {
        //         $table->string('tenant_id')->nullable(); // Change 'id' to the actual column you want to place this after
        //     });
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // foreach ($this->tables as $table) {
        //     Schema::table($table, function (Blueprint $table) {
        //         $table->dropColumn('tenant_id');
        //     });
        // }
    }
};
