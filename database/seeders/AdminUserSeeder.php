<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Using updateOrCreate to avoid duplication
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Condition to find the user
            [ // Values to insert or update if found
                'name' => 'Admin',
                'password' => bcrypt('admin123'), // Always hash the password
                'email_verified_at' => now(),
                'is_admin' => true
            ]
        );
    }
}