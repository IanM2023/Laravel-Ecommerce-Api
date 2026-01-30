<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(
            ['role_name' => 'Admin'],
            ['status' => 0]
        );
        
        Role::updateOrCreate(
            ['role_name' => 'User'],
            ['status' => 0]
        );
        
    }
}
