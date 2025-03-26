<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Retrieve all products",
     *     description="Fetches a list of all products, including soft deleted ones. Returns an empty array if no products exist.",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of products",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="product retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                     @OA\Property(property="uuid", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                     @OA\Property(property="product_category_id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Laptop"),
     *                     @OA\Property(property="price", type="number", example=999.99),
     *                     @OA\Property(property="image", type="string", example="products/laptop.jpg"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-25T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-25T12:00:00Z"),
     *                     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access"
     *     )
     * )
     */
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
    /**
     * @OA\Get(
     *     path="/api/products/{uuid}",
     *     summary="Retrieve a specific product",
     *     description="Fetches a single product by its UUID",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product to retrieve",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful product retrieval",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Product retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                 @OA\Property(property="uuid", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                 @OA\Property(property="product_category_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Laptop"),
     *                 @OA\Property(property="price", type="number", example=999.99),
     *                 @OA\Property(property="image", type="string", example="products/laptop.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-25T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-25T12:00:00Z"),
     *                 @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access"
     *     )
     * )
     */
    public function show($uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product retrieved successfully',
            'data' => $product
        ], 200);
    }
    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create a new product",
     *     description="Creates a new product with the provided details",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"product_category_id", "name", "price", "image"},
     *                 @OA\Property(property="product_category_id", type="integer", description="ID of the product category"),
     *                 @OA\Property(property="name", type="string", description="Name of the product"),
     *                 @OA\Property(property="price", type="number", description="Price of the product"),
     *                 @OA\Property(property="image", type="string", format="binary", description="Product image file")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Product created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                 @OA\Property(property="uuid", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                 @OA\Property(property="product_category_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Laptop"),
     *                 @OA\Property(property="price", type="number", example=999.99),
     *                 @OA\Property(property="image", type="string", example="products/laptop.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-25T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-25T12:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Image upload failed"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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
    /**
     * @OA\Put(
     *     path="/api/products/{uuid}",
     *     summary="Update an existing product",
     *     description="Updates an existing product with the provided details",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product to update",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="product_category_id", type="integer", description="ID of the product category"),
     *                 @OA\Property(property="name", type="string", description="Name of the product"),
     *                 @OA\Property(property="price", type="number", description="Price of the product"),
     *                 @OA\Property(property="image", type="string", format="binary", description="Product image file")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Product updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                 @OA\Property(property="uuid", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                 @OA\Property(property="product_category_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Laptop"),
     *                 @OA\Property(property="price", type="number", example=999.99),
     *                 @OA\Property(property="image", type="string", example="products/laptop.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-25T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-25T12:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->first();
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }
        $request->validate([
            'product_category_id' => 'sometimes|exists:category_products,id',
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path("storage/{$product->image}"))) {
                unlink(public_path("storage/{$product->image}"));
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }
        $product->update($request->only(['product_category_id', 'name', 'price']));
        $product->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }
    /**
     * @OA\Delete(
     *     path="/api/products/{uuid}",
     *     summary="Soft delete a product",
     *     description="Soft deletes a product by its UUID",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product to soft delete",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product soft deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Product soft deleted successfully"),
     *             @OA\Property(property="deleted_at", type="string", format="date-time", example="2025-03-25T12:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access"
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $product = Product::where('uuid', $uuid)->whereNull('deleted_at')->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product soft deleted successfully',
            'deleted_at' => $product->deleted_at
        ]);
    }
    /**
     * @OA\Patch(
     *     path="/api/products/{uuid}/restore",
     *     summary="Restore a soft deleted product",
     *     description="Restores a previously soft deleted product by its UUID",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product to restore",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product restored successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Product restored successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                 @OA\Property(property="uuid", type="string", example="550e8400-e29b-41d4-a716-446655440000"),
     *                 @OA\Property(property="product_category_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Laptop"),
     *                 @OA\Property(property="price", type="number", example=999.99),
     *                 @OA\Property(property="image", type="string", example="products/laptop.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-25T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-25T12:00:00Z"),
     *                 @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found or not deleted"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access"
     *     )
     * )
     */
    public function restore($uuid)
    {
        $product = Product::onlyTrashed()->where('uuid', $uuid)->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found or not deleted'
            ], 404);
        }

        $product->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Product restored successfully',
            'data' => $product
        ], 200);
    }
}
