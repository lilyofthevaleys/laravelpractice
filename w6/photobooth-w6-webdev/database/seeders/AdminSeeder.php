<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pokemart.test'],
            [
                'name' => 'Professor Oak',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
            ]
        );

        User::updateOrCreate(
            ['email' => 'ash@pokemart.test'],
            [
                'name' => 'Ash Ketchum',
                'password' => Hash::make('password'),
                'role' => User::ROLE_CUSTOMER,
            ]
        );
    }
}
