<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Delete existing admin user if exists
        User::where('email', 'admin@volt.com')->delete();

        // Create fresh admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@volt.com',
            'password' => 'secret', // The User model will automatically hash this
            'role' => 'admin',
            'email_verified_at' => now()
        ]);
    }
}
