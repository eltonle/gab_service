<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'superadmin@gmail.com')->first();

        if (is_null($user)) {
            $user = new User();
            $user->name = 'superadmin';
            $user->username = 'administrator';
            $user->email = 'superadmin@gmail.com';
            $user->phone = '690909090';
            $user->address = 'akwa-rue ';
            $user->user_type = 'admin';
            $user->password = Hash::make("password");
            $user->save();
        }
    }
}
