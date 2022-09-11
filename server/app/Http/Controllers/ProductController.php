<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {   
       return Product::all();
    }
    public function store(Request $request)
    {
        $product = new Product([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        $product->save();
        $category = Category::whereIn('name', $request->categories)->get();
        $product->categories()->attach($category);
        return $product;
    }
    public function show(Product $product)
    {
        return $product;
    }
    public function update(Request $request, Product $product)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        if($request->categories){
            $category = Category::whereIn('name', $request->categories)->get();
            $product->categories()->detach($category);
            $product->categories()->attach($category);
        }
        $product->update();
        return $product;
    }
    public function destroy(Product $product)
    {
        CategoryProduct::where('product_id', $product->id)->delete();
        return $product->delete();
    }
    public function export()
    {
        return Excel::download(new ProductExport, 'products.csv');
    }
}
