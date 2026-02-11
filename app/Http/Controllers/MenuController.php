<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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

        $product->update($validated);

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
