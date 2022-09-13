<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {   
       return Product::all();
    }
    public function store(ProductRequest $request)
    {
        $product = new Product([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        $product->save();
        info($request);
        if(!$request->categories) {
            $category = Category::where('name',$request->mainCategory)->get();
            
        }else{

            $category = Category::whereIn('name', $request->categories)->get();
        }
        
        
        $product->categories()->attach($category);

        return $product;
    }
    public function show(Product $product)
    {
        return $product;
    }
    public function update(ProductRequest $request, Product $product)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        CategoryProduct::where('product_id', $product->id)->delete();
        if($request->categories){
            $category = Category::whereIn('name', $request->categories)->get();
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
