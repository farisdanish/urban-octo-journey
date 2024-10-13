<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use updateOrCreate to avoid duplication
        $user = User::updateOrCreate(
            ['email' => 'customer@example.com'], // Condition to find the user
            [ // Values to insert or update if found
                'name' => 'Ahmad Malik',
                'password' => bcrypt('password123'), // Hash the password
                'email_verified_at' => now(),
                'is_admin' => false, // Ensure the customer is not an admin
            ]
        );

        // Create or update the customer record
        Customer::updateOrCreate(
            ['phone' => '0123456789'], // Assuming phone number is unique for each customer
            [ // Values to insert or update if found
                'first_name' => 'Ahmad',
                'last_name' => 'Malik',
                'status' => 'active', // Assuming "active" is a valid status
                'created_by' => $user->id, // Reference to user who created the customer
                'updated_by' => $user->id, // Reference to user who last updated the customer
            ]
        );
    }
}
