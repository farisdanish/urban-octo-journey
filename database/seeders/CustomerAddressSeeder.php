<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log; // Import Log facade for error logging

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assume the customer ID is known
        $customerId = 1; // Adjust this ID based on your database or logic

        // Find the customer by ID
        $customer = Customer::find($customerId);

        // Check if the customer exists
        if ($customer) {
            // Find the state (for example, 'Selangor')
            $state = State::where('name', 'Selangor')->first();

            // Check if the state exists
            if ($state) {
                // Check if the address already exists for the customer
                $existingAddress = CustomerAddress::where('customer_id', $customer->id)
                    ->where('address1', '123, Jalan Bukit') // You can also check by other fields if needed
                    ->first();

                if (!$existingAddress) {
                    // Create customer address using the CustomerAddress model
                    CustomerAddress::create([
                        'type' => 'billing', // Assuming the address is for billing
                        'address1' => '123, Jalan Bukit',
                        'address2' => 'Kampung Baru',
                        'city' => 'Shah Alam',
                        'state_id' => $state->id, // Link to the states table
                        'zipcode' => '40100',
                        'customer_id' => $customerId, // Reference to the customer created above
                    ]);
                } else {
                    // Log an error if the address already exists
                    Log::info('Customer address already exists for customer ID: ' . $customer->id);
                }
            } else {
                // Log an error if the state does not exist
                Log::error('State not found: Selangor');
            }
        } else {
            // Log an error if the customer does not exist
            Log::error('Customer not found with ID: ' . $customerId);
        }
    }
}