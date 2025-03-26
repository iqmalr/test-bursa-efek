<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/category-products",
     *     summary="Retrieve all product categories",
     *     description="Fetches a list of all product categories, including soft deleted ones. Returns an empty array if no categories exist.",
     *     tags={"Category Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of categories",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Categories retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Electronics"),
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
        $categories = CategoryProduct::all();

        if ($categories->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No categories found',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ], 200);
    }
    /**
     * @OA\Post(
     *     path="/api/category-products",
     *     summary="Create a new product category",
     *     description="Allows creation of a new product category with a unique name",
     *     tags={"Category Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Category creation payload",
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(
     *                 property="name", 
     *                 type="string", 
     *                 description="Name of the category",
     *                 maxLength=255,
     *                 example="Electronics"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Electronics"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The name field is required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category = CategoryProduct::create($request->only('name'));
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }
    /**
     * @OA\Get(
     *     path="/api/category-products/{id}",
     *     summary="Retrieve a specific product category",
     *     description="Fetches details of a product category by its unique identifier",
     *     tags={"Category Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Unique identifier of the category",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Electronics"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Category not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $category = CategoryProduct::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Category retrieved successfully',
            'data' => $category
        ], 200);
    }
    /**
     * @OA\Put(
     *     path="/api/category-products/{id}",
     *     summary="Update an existing product category",
     *     description="Allows updating the name of an existing product category",
     *     tags={"Category Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Unique identifier of the category to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Category update payload",
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="New name for the category",
     *                 maxLength=255,
     *                 example="Updated Electronics"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Updated Electronics"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Category not found or validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Category not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $category = CategoryProduct::find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'category not found'
            ], 400);
        }
        $request->validate(['name' => 'required|string|max:255']);
        $category->update($request->only('name'));
        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'data' => $category
        ], 200);
    }
    /**
     * @OA\Delete(
     *     path="/api/category-products/{id}",
     *     summary="Soft delete a product category",
     *     description="Marks a product category as deleted without removing it from the database",
     *     tags={"Category Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Unique identifier of the category to soft delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category soft deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category soft deleted successfully"),
     *             @OA\Property(property="deleted_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Category not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $category = CategoryProduct::where('id', $id)->whereNull('deleted_at')->first();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category soft deleted successfully',
            'deleted_at' => $category->deleted_at
        ]);
    }
    /**
     * @OA\Patch(
     *     path="/api/category-products/{id}/restore",
     *     summary="Restore a soft deleted product category",
     *     description="Restores a previously soft deleted product category",
     *     tags={"Category Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Unique identifier of the category to restore",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category restored successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category restored successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Electronics"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found or not deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Category not found or not deleted")
     *         )
     *     )
     * )
     */
    public function restore($id)
    {
        $category = CategoryProduct::onlyTrashed()->find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found or not deleted'
            ], 404);
        }

        $category->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Category restored successfully',
            'data' => $category
        ], 200);
    }
}
