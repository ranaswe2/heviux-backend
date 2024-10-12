<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductImageRequest;

class ProductImageController extends Controller
{
    public function store(ProductImageRequest $request)
    {
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Invalid request format.'], 400);
        }
        
        $validatedData = $request->validated();

        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        // Assuming you have a Product model and want to associate the image with a specific product
        $product = Product::find($validatedData['product_id']);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $productImage = $request->file('product_image');
        $imageName = $product->id . '.' . time() . '.' . $productImage->getClientOriginalExtension();
        $imagePath = 'product_images/';

        // Move the image to the storage path
        $productImage->move(public_path($imagePath), $imageName);

        // Create a ProductImage record
        $created = ProductImage::create([
            'product_id' => $product->id,
            'image_name' => $imageName,
            'path' => $imagePath . $imageName, // Assuming you want to store the full path
            'created_by' => $admin->id,
        ]);

        if ($created) {
            return response()->json($created, 201);
        }

        return response()->json(['message' => 'Creation Failed!'], 401);
    }

    public function show($id)
    {
        $productImage = ProductImage::findOrFail($id);
        return response()->json($productImage);
    }

    public function destroy($id)
    {
        $productImage = ProductImage::findOrFail($id);

        // Delete image file from public/product_images folder
        Storage::delete($productImage->path);

        // Delete the database record
        $productImage->delete();

        return response()->json(null, 204);
    }

   
}
