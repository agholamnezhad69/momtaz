<?php

namespace ali\User\Database\seeds;

use ali\User\Models\User;
use Illuminate\Database\Seeder;


class UserTableSeeder extends Seeder
{
    public function run()
    {
        foreach (User::$defaultUser as $user) {

            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    "email" => $user['email'],
                    "password" => $user['password'],
                    "name" => $user['name'],
                ]
            )->assignRole($user["role"]);
        }


    }
}
