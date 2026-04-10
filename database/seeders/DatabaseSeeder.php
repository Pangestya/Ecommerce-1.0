<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Admin',
            'email' => 'ghoffar.pangestya@gmail.com',
            'password' => Hash::make('ghoffar123'),
            'role' => '1',
            'email_verified_at' => now()
        ]);

        // Buat Akun Pengawas
        User::create([
            'name' => 'Pengawas',
            'email' => 'ghoffar.cial@gmail.com',
            'password' => Hash::make('ghoffar123'),
            'role' => '2',
            'email_verified_at' => now()
        ]);

        // Buat Akun Pembeli
        User::create([
            'name' => 'Pembeli',
            'email' => 'parsya.ghoffar@gmail.com',
            'password' => Hash::make('ghoffar123'),
            'role' => '3',
            'email_verified_at' => now()
        ]);
    }
}