<?php

namespace Database\Seeders;

use App\Models\Permission;
use DB;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('permissions')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            [
                'id' => 1,
                'title' => 'user_management_access',
            ],
            [
                'id' => 2,
                'title' => 'permission_create',
            ],
            [
                'id' => 3,
                'title' => 'permission_edit',
            ],
            [
                'id' => 4,
                'title' => 'permission_show',
            ],
            [
                'id' => 5,
                'title' => 'permission_delete',
            ],
            [
                'id' => 6,
                'title' => 'permission_access',
            ],
            [
                'id' => 7,
                'title' => 'role_create',
            ],
            [
                'id' => 8,
                'title' => 'role_edit',
            ],
            [
                'id' => 9,
                'title' => 'role_show',
            ],
            [
                'id' => 10,
                'title' => 'role_delete',
            ],
            [
                'id' => 11,
                'title' => 'role_access',
            ],
            [
                'id' => 12,
                'title' => 'user_create',
            ],
            [
                'id' => 13,
                'title' => 'user_edit',
            ],
            [
                'id' => 14,
                'title' => 'user_show',
            ],
            [
                'id' => 15,
                'title' => 'user_delete',
            ],
            [
                'id' => 16,
                'title' => 'user_access',
            ],
            [
                'id' => 17,
                'title' => 'master_data_managment_access',
            ],
            [
                'id' => 18,
                'title' => 'designation_create',
            ],
            [
                'id' => 19,
                'title' => 'designation_edit',
            ],
            [
                'id' => 20,
                'title' => 'designation_show',
            ],
            [
                'id' => 21,
                'title' => 'designation_delete',
            ],
            [
                'id' => 22,
                'title' => 'designation_access',
            ],
            [
                'id' => 23,
                'title' => 'member_create',
            ],
            [
                'id' => 24,
                'title' => 'member_edit',
            ],
            [
                'id' => 25,
                'title' => 'member_show',
            ],
            [
                'id' => 26,
                'title' => 'member_delete',
            ],
            [
                'id' => 27,
                'title' => 'member_access',
            ],
            [
                'id' => 28,
                'title' => 'department_create',
            ],
            [
                'id' => 29,
                'title' => 'department_edit',
            ],
            [
                'id' => 30,
                'title' => 'department_show',
            ],
            [
                'id' => 31,
                'title' => 'department_delete',
            ],
            [
                'id' => 32,
                'title' => 'department_access',
            ],
            [
                'id' => 33,
                'title' => 'membership_category_create',
            ],
            [
                'id' => 34,
                'title' => 'membership_category_edit',
            ],
            [
                'id' => 35,
                'title' => 'membership_category_show',
            ],
            [
                'id' => 36,
                'title' => 'membership_category_delete',
            ],
            [
                'id' => 37,
                'title' => 'membership_category_access',
            ],
            [
                'id' => 38,
                'title' => 'membership_type_create',
            ],
            [
                'id' => 39,
                'title' => 'membership_type_edit',
            ],
            [
                'id' => 40,
                'title' => 'membership_type_show',
            ],
            [
                'id' => 41,
                'title' => 'membership_type_delete',
            ],
            [
                'id' => 42,
                'title' => 'membership_type_access',
            ],
            [
                'id' => 43,
                'title' => 'profile_password_edit',
            ],
            [
                'id' => 44,
                'title' => 'dependent_create',
            ],
            [
                'id' => 45,
                'title' => 'dependent_access',
            ],
            [
                'id' => 46,
                'title' => 'dependent_edit',
            ],
            [
                'id' => 47,
                'title' => 'dependent_delete',
            ],
            [
                'id' => 48,
                'title' => 'dependent_show',
            ],
            [
                'id' => 49,
                'title' => 'dependent_list',
            ],
            [
                'id' => 50,
                'title' => 'csv_import',
            ],

            [
                'id' => 51,
                'title' => 'inventory_data_managment_access',
            ],
            [
                'id' => 52,
                'title' => 'store_create',
            ],
            [
                'id' => 53,
                'title' => 'store_edit',
            ],
            [
                'id' => 54,
                'title' => 'store_show',
            ],
            [
                'id' => 55,
                'title' => 'store_delete',
            ],
            [
                'id' => 56,
                'title' => 'store_access',
            ],
            [
                'id' => 57,
                'title' => 'vendor_create',
            ],
            [
                'id' => 58,
                'title' => 'vendor_edit',
            ],
            [
                'id' => 59,
                'title' => 'vendor_delete',
            ],
            [
                'id' => 60,
                'title' => 'vendor_access',
            ],
            [
                'id' => 61,
                'title' => 'unit_create',
            ],
            [
                'id' => 62,
                'title' => 'unit_edit',
            ],
            [
                'id' => 63,
                'title' => 'unit_show',
            ],
            [
                'id' => 64,
                'title' => 'unit_delete',
            ],
            [
                'id' => 65,
                'title' => 'unit_access',
            ],
            [
                'id' => 66,
                'title' => 'item_type_create',
            ],
            [
                'id' => 67,
                'title' => 'item_type_edit',
            ],
            [
                'id' => 68,
                'title' => 'item_type_show',
            ],
            [
                'id' => 69,
                'title' => 'item_type_delete',
            ],
            [
                'id' => 70,
                'title' => 'item_type_access',
            ],
            [
                'id' => 71,
                'title' => 'good_receipt_create',
            ],
            [
                'id' => 72,
                'title' => 'good_receipt_edit',
            ],
            [
                'id' => 73,
                'title' => 'good_receipt_show',
            ],
            [
                'id' => 74,
                'title' => 'good_receipt_delete',
            ],
            [
                'id' => 75,
                'title' => 'good_receipt_access',
            ],
            [
                'id' => 76,
                'title' => 'store_item_create',
            ],
            [
                'id' => 77,
                'title' => 'store_item_edit',
            ],
            [
                'id' => 78,
                'title' => 'store_item_show',
            ],
            [
                'id' => 79,
                'title' => 'store_item_delete',
            ],
            [
                'id' => 80,
                'title' => 'store_item_access',
            ],

            [
                'id' => 81,
                'title' => 'gr_item_detail_create',
            ],
            [
                'id' => 82,
                'title' => 'gr_item_detail_edit',
            ],
            [
                'id' => 83,
                'title' => 'gr_item_detail_show',
            ],
            [
                'id' => 84,
                'title' => 'gr_item_detail_delete',
            ],
            [
                'id' => 85,
                'title' => 'gr_item_detail_access',
            ],
            [
                'id' => 86,
                'title' => 'section_create',
            ],
            [
                'id' => 87,
                'title' => 'section_edit',
            ],
            [
                'id' => 88,
                'title' => 'section_show',
            ],
            [
                'id' => 89,
                'title' => 'section_delete',
            ],
            [
                'id' => 90,
                'title' => 'section_access',
            ],
            [
                'id' => 91,
                'title' => 'hr_management_access',
            ],
            [
                'id' => 92,
                'title' => 'employee_create',
            ],
            [
                'id' => 93,
                'title' => 'employee_edit',
            ],
            [
                'id' => 94,
                'title' => 'employee_show',
            ],
            [
                'id' => 95,
                'title' => 'employee_delete',
            ],
            [
                'id' => 96,
                'title' => 'employee_access',
            ],
            [
                'id' => 97,
                'title' => 'stock_issue_create',
            ],
            [
                'id' => 98,
                'title' => 'stock_issue_edit',
            ],
            [
                'id' => 99,
                'title' => 'stock_issue_show',
            ],
            [
                'id' => 100,
                'title' => 'stock_issue_delete',
            ],
            [
                'id' => 101,
                'title' => 'stock_issue_access',
            ],
            [
                'id' => 102,
                'title' => 'stock_issue_item_create',
            ],
            [
                'id' => 103,
                'title' => 'stock_issue_item_edit',
            ],
            [
                'id' => 104,
                'title' => 'stock_issue_item_show',
            ],
            [
                'id' => 105,
                'title' => 'stock_issue_item_delete',
            ],
            [
                'id' => 106,
                'title' => 'stock_issue_item_access',
            ],
            [
                'id' => 107,
                'title' => 'section_access',
            ],
            [
                'id' => 108,
                'title' => 'dependent_csv_import',
            ],
            [
                'id' => 109,
                'title' => 'restaurant_managment_access',
            ],
            [
                'id' => 110,
                'title' => 'menu_create',
            ],
            [
                'id' => 111,
                'title' => 'menu_edit',
            ],
            [
                'id' => 112,
                'title' => 'menu_show',
            ],
            [
                'id' => 113,
                'title' => 'menu_delete',
            ],
            [
                'id' => 114,
                'title' => 'menu_access',
            ],
            [
                'id' => 115,
                'title' => 'menu_item_category_create',
            ],
            [
                'id' => 116,
                'title' => 'menu_item_category_edit',
            ],
            [
                'id' => 117,
                'title' => 'menu_item_category_show',
            ],
            [
                'id' => 118,
                'title' => 'menu_item_category_delete',
            ],
            [
                'id' => 119,
                'title' => 'menu_item_category_access',
            ],
            [
                'id' => 120,
                'title' => 'item_create',
            ],
            [
                'id' => 121,
                'title' => 'item_edit',
            ],
            [
                'id' => 122,
                'title' => 'item_show',
            ],
            [
                'id' => 123,
                'title' => 'item_delete',
            ],
            [
                'id' => 124,
                'title' => 'item_access',
            ],
            [
                'id' => 125,
                'title' => 'table_top_create',
            ],
            [
                'id' => 126,
                'title' => 'table_top_edit',
            ],
            [
                'id' => 127,
                'title' => 'table_top_show',
            ],
            [
                'id' => 128,
                'title' => 'table_top_delete',
            ],
            [
                'id' => 129,
                'title' => 'table_top_access',
            ],
            [
                'id' => 130,
                'title' => 'order_create',
            ],
            [
                'id' => 131,
                'title' => 'order_edit',
            ],
            [
                'id' => 132,
                'title' => 'order_show',
            ],
            [
                'id' => 133,
                'title' => 'order_delete',
            ],
            [
                'id' => 134,
                'title' => 'order_access',
            ],
            [
                'id' => 135,
                'title' => 'order_item_create',
            ],
            [
                'id' => 136,
                'title' => 'order_item_edit',
            ],
            [
                'id' => 137,
                'title' => 'order_item_show',
            ],
            [
                'id' => 138,
                'title' => 'order_item_delete',
            ],
            [
                'id' => 139,
                'title' => 'order_item_access',
            ],
            [
                'id' => 140,
                'title' => 'transaction_create',
            ],
            [
                'id' => 141,
                'title' => 'transaction_edit',
            ],
            [
                'id' => 142,
                'title' => 'transaction_show',
            ],
            [
                'id' => 143,
                'title' => 'transaction_delete',
            ],
            [
                'id' => 144,
                'title' => 'transaction_access',
            ],
            [
                'id' => 145,
                'title' => 'profile_password_edit',
            ],
            [
                'id' => 146,
                'title' => 'sports_division_create',
            ],
            [
                'id' => 147,
                'title' => 'sports_division_edit',
            ],
            [
                'id' => 148,
                'title' => 'sports_division_show',
            ],
            [
                'id' => 149,
                'title' => 'sports_division_delete',
            ],
            [
                'id' => 150,
                'title' => 'sports_division_access',
            ],
            [
                'id' => 151,
                'title' => 'sport_access',
            ],
            [
                'id' => 152,
                'title' => 'sport_item_type_create',
            ],
            [
                'id' => 153,
                'title' => 'sport_item_type_edit',
            ],
            [
                'id' => 154,
                'title' => 'sport_item_type_show',
            ],
            [
                'id' => 155,
                'title' => 'sport_item_type_delete',
            ],
            [
                'id' => 156,
                'title' => 'sport_item_type_access',
            ],
            [
                'id' => 157,
                'title' => 'sport_item_class_create',
            ],
            [
                'id' => 158,
                'title' => 'sport_item_class_edit',
            ],
            [
                'id' => 159,
                'title' => 'sport_item_class_show',
            ],
            [
                'id' => 160,
                'title' => 'sport_item_class_delete',
            ],
            [
                'id' => 161,
                'title' => 'sport_item_class_access',
            ],
            [
                'id' => 162,
                'title' => 'sport_item_name_create',
            ],
            [
                'id' => 163,
                'title' => 'sport_item_name_edit',
            ],
            [
                'id' => 164,
                'title' => 'sport_item_name_show',
            ],
            [
                'id' => 165,
                'title' => 'sport_item_name_delete',
            ],
            [
                'id' => 166,
                'title' => 'sport_item_name_access',
            ],
            [
                'id' => 167,
                'title' => 'profile_password_edit',
            ],
            [
                'id' => 168,
                'title' => 'billing_access',
            ],
            [
                'id' => 169,
                'title' => 'sports_billing_create',
            ],
            [
                'id' => 170,
                'title' => 'sports_billing_edit',
            ],
            [
                'id' => 171,
                'title' => 'sports_billing_show',
            ],
            [
                'id' => 172,
                'title' => 'sports_billing_delete',
            ],
            [
                'id' => 173,
                'title' => 'sports_billing_access',
            ],
            [
                'id' => 174,
                'title' => 'sport_billing_item_create',
            ],
            [
                'id' => 175,
                'title' => 'sport_billing_item_edit',
            ],
            [
                'id' => 176,
                'title' => 'sport_billing_item_show',
            ],
            [
                'id' => 177,
                'title' => 'sport_billing_item_delete',
            ],
            [
                'id' => 178,
                'title' => 'sport_billing_item_access',
            ],
            [
                'id' => 179,
                'title' => 'profile_password_edit',
            ],
            [
                'id' => 180,
                'title' => 'item_class_create',
            ],
            [
                'id' => 181,
                'title' => 'item_class_edit',
            ],
            [
                'id' => 182,
                'title' => 'item_class_show',
            ],
            [
                'id' => 183,
                'title' => 'item_class_delete',
            ],
            [
                'id' => 184,
                'title' => 'item_class_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
