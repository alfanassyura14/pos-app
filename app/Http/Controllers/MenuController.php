<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with('category')->get();
        $menuTypes = ['Normal Menu', 'Special Deals', 'New Year Special', 'Deserts and Drinks'];
        
        return view('menu', compact('categories', 'products', 'menuTypes'));
    }

    // Category Methods
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'c_name' => 'required|string|max:255',
            'c_description' => 'nullable|string',
            'icon' => 'nullable|string',
            'menu_type' => 'required|string',
        ]);

        $category = Category::create($validated);

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'c_name' => 'required|string|max:255',
            'c_description' => 'nullable|string',
            'icon' => 'nullable|string',
            'menu_type' => 'required|string',
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    // Product Methods
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'p_name' => 'required|string|max:255',
            'p_description' => 'nullable|string',
            'p_price' => 'required|numeric|min:0',
            'p_stock' => 'required|integer|min:0',
            'p_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('p_image')) {
            $imagePath = $request->file('p_image')->store('products', 'public');
            $validated['p_image'] = $imagePath;
        }

        // Determine status based on stock
        if ($validated['p_stock'] == 0) {
            $validated['p_status'] = 'Out of Stock';
        } elseif ($validated['p_stock'] < 10) {
            $validated['p_status'] = 'Low Stock';
        } else {
            $validated['p_status'] = 'In Stock';
        }

        $product = Product::create($validated);

        // Create notification for new menu
        Notification::create([
            'type' => 'new_menu',
            'title' => 'New Menu Added',
            'message' => "New product '{$product->p_name}' has been added to the menu.",
            'data' => ['product_id' => $product->id],
        ]);

        // Check for low stock notification
        if ($validated['p_stock'] <= 5) {
            Notification::create([
                'type' => 'low_stock',
                'title' => 'Low Stock Alert',
                'message' => "Product '{$product->p_name}' has low stock ({$validated['p_stock']} left).",
                'data' => ['product_id' => $product->id, 'stock' => $validated['p_stock']],
            ]);
        }

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'p_name' => 'required|string|max:255',
            'p_description' => 'nullable|string',
            'p_price' => 'required|numeric|min:0',
            'p_stock' => 'required|integer|min:0',
            'p_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('p_image')) {
            // Delete old image if exists
            if ($product->p_image) {
                Storage::disk('public')->delete($product->p_image);
            }
            $imagePath = $request->file('p_image')->store('products', 'public');
            $validated['p_image'] = $imagePath;
        }

        // Determine status based on stock
        if ($validated['p_stock'] == 0) {
            $validated['p_status'] = 'Out of Stock';
        } elseif ($validated['p_stock'] < 10) {
            $validated['p_status'] = 'Low Stock';
        } else {
            $validated['p_status'] = 'In Stock';
        }

        // Check for stock changes before update
        $oldStock = $product->p_stock;
        $newStock = $validated['p_stock'];
        $stockChanged = $oldStock != $newStock;
        $stockIncreased = $newStock > $oldStock;

        $product->update($validated);

        // Create notification for menu update
        Notification::create([
            'type' => 'menu_update',
            'title' => 'Menu Updated',
            'message' => "Product '{$product->p_name}' information has been updated.",
            'data' => ['product_id' => $product->id],
        ]);

        // Create notification for stock increase
        if ($stockChanged && $stockIncreased) {
            $stockDiff = $newStock - $oldStock;
            Notification::create([
                'type' => 'stock_update',
                'title' => 'Stock Added',
                'message' => "Stock added to '{$product->p_name}': +{$stockDiff} items (Total: {$newStock}).",
                'data' => ['product_id' => $product->id, 'old_stock' => $oldStock, 'new_stock' => $newStock],
            ]);
        }

        // Check for low stock notification
        if ($newStock <= 5 && $newStock > 0) {
            Notification::create([
                'type' => 'low_stock',
                'title' => 'Low Stock Alert',
                'message' => "Product '{$product->p_name}' is running low on stock ({$newStock} left).",
                'data' => ['product_id' => $product->id, 'stock' => $newStock],
            ]);
        }

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->p_image) {
            Storage::disk('public')->delete($product->p_image);
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}
