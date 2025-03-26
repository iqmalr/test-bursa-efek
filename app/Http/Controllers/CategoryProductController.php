<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/category-products",
     *     summary="Get all categories",
     *     tags={"Category Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Electronics"),
     *                 @OA\Property(property="created_at", type="string", example="2025-03-25T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-03-25T12:00:00Z")
     *             )
     *         )
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
     *     summary="Create a new category",
     *     tags={"Category Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Electronics")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Validation error")
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
}
