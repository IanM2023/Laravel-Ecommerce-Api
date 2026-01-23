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
            'first_name' => 'John',
            'middle_name' => 'X',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'role_id' => 1,
            'password' => Hash::make('12345678')
        ]);
    }
}