<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        // Fetches all permissions
        $admin_permissions = Permission::all();

        // Finding super admin and attaching all permissions to it.
        Role::findOrFail(3)->permissions()->sync($admin_permissions->pluck('id'));


        // fetching permission for role user
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'csv_'
                && substr($permission->title, 0, 5) != 'user_'
                && substr($permission->title, 0, 5) != 'role_'
                && substr($permission->title, 0, 11) != 'permission_'
                && substr($permission->title, 0, 11) != 'order_'
                && substr($permission->title, 0, 11) != 'stock_'
                && substr($permission->title, 0, 11) != 'transactions_';
        });

        // fetching permissions for role admin
        $admin_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0) != 'csv_'
                && substr($permission->title, 0) != 'role_'
                && substr($permission->title, 0) != 'user_'
                && substr($permission->title, 0) != 'permission_'
                && substr($permission->title, 0) != 'order_'
                && substr($permission->title, 0) != 'stock_'
                && substr($permission->title, 0) != 'transactions_';
        });


        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        Role::findOrFail(2)->permissions()->sync($user_permissions->pluck('id'));
    }
}
