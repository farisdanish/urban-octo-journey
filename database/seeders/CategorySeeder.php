<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete all existing records in the categories table
        Category::query()->delete();

        // Assuming you have a user to reference for created_by and updated_by fields
        $user = User::first(); // Get the first user (assuming an admin user exists)

        // Define the categories with parent-child relationships
        $categories = [
            [
                'name' => 'Laptops & PCs',
                'slug' => 'laptops-pcs',
                'active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Gaming Laptops',
                'slug' => 'gaming-laptops',
                'active' => true,
                'parent_id' => 1, // Assuming the id of 'Laptops & PCs' is 1
            ],
            [
                'name' => 'Business Laptops',
                'slug' => 'business-laptops',
                'active' => true,
                'parent_id' => 1, // Assuming the id of 'Laptops & PCs' is 1
            ],
            [
                'name' => 'Peripherals',
                'slug' => 'peripherals',
                'active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Mice',
                'slug' => 'mice',
                'active' => true,
                'parent_id' => 4, // Assuming the id of 'Peripherals' is 4
            ],
            [
                'name' => 'Keyboards',
                'slug' => 'keyboards',
                'active' => true,
                'parent_id' => 4, // Assuming the id of 'Peripherals' is 4
            ],
            [
                'name' => 'Audio',
                'slug' => 'audio',
                'active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Headphones',
                'slug' => 'headphones',
                'active' => true,
                'parent_id' => 7, // Assuming the id of 'Audio' is 7
            ],
            [
                'name' => 'Speakers',
                'slug' => 'speakers',
                'active' => true,
                'parent_id' => 7, // Assuming the id of 'Audio' is 7
            ],
            [
                'name' => 'Consoles',
                'slug' => 'consoles',
                'active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'PlayStation',
                'slug' => 'playstation',
                'active' => true,
                'parent_id' => 9, // Assuming the id of 'Consoles' is 9
            ],
            [
                'name' => 'Xbox',
                'slug' => 'xbox',
                'active' => true,
                'parent_id' => 9, // Assuming the id of 'Consoles' is 9
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Cables',
                'slug' => 'cables',
                'active' => true,
                'parent_id' => 13, // Assuming the id of 'Accessories' is 13
            ],
            [
                'name' => 'Chargers',
                'slug' => 'chargers',
                'active' => true,
                'parent_id' => 13, // Assuming the id of 'Accessories' is 13
            ],
        ];

        // Seed the categories
        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'active' => $category['active'],
                'parent_id' => $category['parent_id'],
                'created_by' => $user ? $user->id : null, // Use the first user's ID for created_by
                'updated_by' => $user ? $user->id : null, // Use the first user's ID for updated_by
            ]);
        }
    }
}