<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::query()->delete();

        // Fetch all products and categories
        $products = Product::all();
        $categories = Category::all();

        // Check if we have products and categories
        if ($products->isEmpty() || $categories->isEmpty()) {
            return; // Exit if there are no products or categories to assign
        }

        foreach ($products as $product) {
            // Randomly assign between 1 to 3 categories to each product
            $randomCategories = $categories->random(rand(1, 3));

            foreach ($randomCategories as $category) {
                ProductCategory::create([
                    'product_id' => $product->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}