<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@hipmi-jabar.org',
            'password' => Hash::make('Svp3r4dm1N@2O2S'),
            'category' => 'super_admin',
            'domisili' => null,
        ]);
    }
}