<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        // Get all products
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function show($id)
    {
        // Get a specific product by ID
        $product = Product::findOrFail($id);
        return response()->json($product, 200);
    }

    public function store(Request $request)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        $request['created_by'] = Auth::id();
        $product = Product::create($request->all());
        return response()->json($product, 200);
    }

    public function update(Request $request, $id)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        $product = Product::findOrFail($id);
        $request['modified_by'] = Auth::id();
        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        // Delete a specific product by ID
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product removed successfully!'] , 200);
    }



    /////////////////////////////////////////////////////////////

    public function getProductImages($id)
    {
        $product = Product::findOrFail($id);
        $images = $product->productImages;
        return response()->json($images, 200);
    }

    public function getProductSizes($id)
    {
        $product = Product::findOrFail($id);
        $sizes = $product->productSizes;
        return response()->json($sizes, 200);
    }

    public function getProductDiscounts($id)
    {
        $product = Product::findOrFail($id);
        $discounts = $product->discounts;
        return response()->json($discounts, 200);
    }

    /////////////////////////////////////////////////////////////

    public function getAllProductsRandomOrder()
    {
        $products = Product::inRandomOrder()->get();
        return response()->json($products, 200);
    }

    public function getProductsByCategory($category)
    {
        $products = Product::where('category', $category)->get();
        return response()->json($products, 200);
    }

    public function getProductsBySubCategory($subCategory)
    {
        $products = Product::where('sub_category', $subCategory)->get();
        return response()->json($products, 200);
    }

    public function getProductsByCategoryRandomOrder($category)
    {
        $products = Product::where('category', $category)->inRandomOrder()->get();
        return response()->json($products, 200);
    }

    public function getProductsBySubCategoryRandomOrder($subCategory)
    {
        $products = Product::where('sub_category', $subCategory)->inRandomOrder()->get();
        return response()->json($products, 200);
    }
    
    public function restoreProduct($id)
    {
        $product = Product::withTrashed()->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Check if the product is soft deleted
        if ($product->trashed()) {
            $product->restore();
            return response()->json(['message' => 'Product restored successfully'], 200);
        } else {
            return response()->json(['message' => 'Product is not deleted'], 400);
        }
    }

}

