<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name'     => 'Admin',
            'phone'    => '01900000000',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role_id'  => User::SUPER_ADMIN,
        ]);
    }
}
