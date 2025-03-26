<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}
