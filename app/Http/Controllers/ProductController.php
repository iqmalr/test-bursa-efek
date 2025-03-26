<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();

        if ($product->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No product found',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'product retrieved successfully',
            'data' => $product
        ], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required|exists:category_products,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $uuid = Str::uuid()->toString();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Image upload failed'
            ], 400);
        }
        $product = Product::create([
            'id' => $uuid,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'price' => $request->price,
            'image' => $path
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }
}
