<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Mostrar productos API
     */
    public function index()
    {
        return response()->json(
            Product::all()
        );
    }
}