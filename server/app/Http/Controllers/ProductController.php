<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
    //     if(request('search')){
    //         return Product::where('name', 'LIKE', '%'. request('search') .'%')->orderBy('id', 'desc')->paginate(2);
    //     }
    //    $product =  Product::orderBy('id', 'desc')->paginate(2);
        // $category = Category::all();
         $product = Product::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%');
         })
         ->orderBy('id', 'desc')
         ->with('categories')
         ->paginate(2);
        //$product = Product::with('categories')->get();
        return $product;
        
    }
    public function show(Product $product)
    {
        return ["product" => $product , 'category' => $product->categories];
    }
    public function store(Request $request)
    {
        info($request);
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
        ]);
        // $category = Category::whereIn('name', $request->category)->get();
        // info($category);
        $product = new Product([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        $product->save();

        $category = Category::whereIn('name', $request->category)->get();
        $product->categories()->attach($category);
        
        return $product;
    }
    public function update(Request $request, Product $product)
    {
        info($request->all());
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
        ]);
        $product->name = $request->name;
        $product->price = $request->price;
        if ($request->category) {
            CategoryProduct::where('product_id', $product->id)->delete();
            $category = Category::whereIn('name', $request->category)->get();
            $product->categories()->attach($category);
        }
        $product->update();
        return $product;
    }
    public function destroy(Product $product)
    {
        return $product->delete();
    }
}
