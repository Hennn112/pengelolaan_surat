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
        User::create([
            'name' => 'Staff TU',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('staff'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Guru TU',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('guru'),
            'role' => 'guru',
        ]);
    }
}
