<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create the demo user with ID: tupaikidal, password: Kambingguling_001
        User::create([
            'name'     => 'Gema Pelajar',
            'username' => 'tupaikidal',
            'email'    => 'tupaikidal@mappypath.id',
            'password' => Hash::make('Kambingguling_001'),
            'role'     => 'student',
        ]);

        // Optional admin user
        User::create([
            'name'     => 'Admin MappyPath',
            'username' => 'admin',
            'email'    => 'admin@mappypath.id',
            'password' => Hash::make('Admin@123'),
            'role'     => 'admin',
        ]);
    }
}
