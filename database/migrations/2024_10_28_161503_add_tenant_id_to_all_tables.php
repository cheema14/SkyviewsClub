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
        'activity_log',
        'bills',
        'departments',
        'dependents',
        // 'designations',
        'discounted_membership_fees',
        'employees',
        'employees_dependents',
        'good_receipts',
        'gr_item_details',
        'item_classes',
        'item_menu',
        'item_order',
        'item_types',
        'items',
        'jobs',
        'kitchen_order_history',
        'media',
        'members',
        'membership_categories',
        'membership_types',
        'menu_item_categories',
        'menu_menu_item_category',
        'menu_role',
        'menus',
        'monthly_bills',
        'order_items',
        'orders',
        'password_resets',
        'payment_receipts',
        'permissions',
        'personal_access_tokens',
        'roles',
        'sport_billing_items',
        'sport_item_classes',
        'sport_item_names',
        'sport_item_types',
        'sports_billings',
        'sports_divisions',
        'stock_issue_items',
        'stock_issues',
        'store_items',
        'stores',
        'table_tops',
        'transactions',
        'units',
        'vendors',
        'room_bookings',
        'room_categories',
        'room_category_charges',
        'rooms',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('tenant_id')->nullable(); // Change 'id' to the actual column you want to place this after
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('tenant_id');
            });
        }
    }
};
