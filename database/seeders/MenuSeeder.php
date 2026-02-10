<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            [
                'name' => 'Pizza',
                'description' => 'Delicious Italian pizzas',
                'icon' => '🍕',
                'menu_type' => 'Normal Menu'
            ],
            [
                'name' => 'Burger',
                'description' => 'Juicy burgers and sandwiches',
                'icon' => '🍔',
                'menu_type' => 'Normal Menu'
            ],
            [
                'name' => 'Chicken',
                'description' => 'Crispy fried chicken',
                'icon' => '🍗',
                'menu_type' => 'Normal Menu'
            ],
            [
                'name' => 'Bakery',
                'description' => 'Fresh baked goods',
                'icon' => '🎂',
                'menu_type' => 'Normal Menu'
            ],
            [
                'name' => 'Beverage',
                'description' => 'Refreshing drinks',
                'icon' => '🥤',
                'menu_type' => 'Normal Menu'
            ],
            [
                'name' => 'Seafood',
                'description' => 'Fresh seafood dishes',
                'icon' => '🍤',
                'menu_type' => 'Normal Menu'
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);

            // Create sample products for each category
            if ($category->name === 'Chicken') {
                Product::create([
                    'category_id' => $category->id,
                    'name' => 'Chicken Parmesan',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing',
                    'price' => 55.00,
                    'stock' => 118,
                    'status' => 'In Stock',
                    'serving' => '1 person'
                ]);
            }
        }
    }
}
