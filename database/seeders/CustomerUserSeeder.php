<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerUserSeeder extends Seeder
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
            ['email' => 'customer@example.com'], // Condition to find the user
            [ // Values to insert or update if found
                'name' => 'Ahmad Malik',
                'password' => bcrypt('password123'), // Hash the password
                'email_verified_at' => now(),
                'is_admin' => false, // Ensure the customer is not an admin
            ]
        );
    }
}
