<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'username' => 'paf.admin',
                'password' => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id' => 2,
                'name' => 'Super Admin',
                'email' => 'super-admin@pafskyviews.com',
                'username' => 'super.admin',
                'password' => bcrypt('Pakistan@123'),
                'remember_token' => null,
            ],
            [
                'id' => 3,
                'name' => 'Order Taker',
                'email' => 'order-taker@pafskyviews.com',
                'username' => 'order.taker',
                'password' => bcrypt('ordertaker123'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
