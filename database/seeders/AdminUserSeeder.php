<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'surname' => 'Root',
            'fiscal_code' => 'ADMIN001',
            'state' => 'IT',
            'user_group' => User::GROUP_ADMIN,
            'email' => 'admin@mail.com',
            'password' => Hash::make('test'),
        ]);
    }
}
