<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'System',
                'last_name' => 'Admin',
                'username' => 'systemadmin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'phone_number' => '+32498190255',
                'email_verified_at' => now(),
                'user_type' => 'super_admin',
                'status' => 'active',
            ],
            [
                'first_name' => 'Demo',
                'last_name' => 'Admin',
                'username' => 'demoadmin',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'phone_number' => '+34298190255',
                'email_verified_at' => now(),
                'user_type' => 'admin',
            ],
            [
                'first_name' => 'Manager demao',
                'last_name' => 'Manager',
                'username' => 'demomanager',
                'email' => 'manager@example.com',
                'password' => bcrypt('password'),
                'phone_number' => '+34298190255',
                'email_verified_at' => now(),
                'user_type' => 'manager',
            ],
            [
                'first_name' => 'John',
                'last_name' => 'User',
                'username' => 'user',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'phone_number' => '+32498190255',
                'email_verified_at' => now(),
                'user_type' => 'user',
                'status' => 'inactive'
            ]
        ];
        foreach ($users as $key => $value) {
            $user = User::create($value);
            $user->assignRole($value['user_type']);
        }
    }
}
