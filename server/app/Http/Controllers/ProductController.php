<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {   
        // $products =  DB::table('category_products')                 
        // ->select('categories.name as category_name','categories.parent_id','products.price','products.name as product_name')
        // ->join('categories', 'category_products.category_id', 'categories.id')
        // ->join('products', 'category_products.product_id', 'products.id')
        // ->get();
        // return $products;
        $products = Product::find(1);
        $categories= Category::all();
        return $products->categories()->get();
       return $products;
    }
    public function store(Request $request)
    {

    }
}
