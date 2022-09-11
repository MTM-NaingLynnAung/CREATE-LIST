<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products', 'children'])->get();
        return response()->json(CategoryResource::collection($categories));
    }
    public function store(Request $request)
    {
       
    }
}
