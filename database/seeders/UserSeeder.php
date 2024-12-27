<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'muhammedaydiiinnn@gmail.com',
            'password' => Hash::make('Ma.232323'),
        ]);

        $superAdminRole = Role::where('name', 'admin')->first();
        $superAdmin->roles()->attach($superAdminRole);
    }
}
