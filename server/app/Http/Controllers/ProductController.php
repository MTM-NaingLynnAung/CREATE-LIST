<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%');
         })
         ->orderBy('id', 'desc')
         ->with('categories')
         ->paginate(2);
        return ProductResource::collection($product);
        
    }
    public function show(Product $product)
    {
        // return ["product" => $product , 'category' => $product->categories];
        return new ProductResource($product);
    }
    public function store(Request $request)
    {
        info($request->file('image'));    
        $files= [];
        $request->category = explode(',', $request->category);
        $category = Category::whereIn('name', $request->category)->get();
        
        $request->validate([
            'name' => ['required','unique:products', 'max:255'],
            'price' => ['required','max:15', 'gt:0'],
            'category' => ['required'],
            'image' => ['required'],
            'image.*' => ['mimes:jpg,png,jpeg','max:300'],
        ]);
        foreach ($request->file('image') as $image) {
            $fileName = rand(1000,10000).'.'.$image->extension();
            Storage::putFileAs('public/images', $image, $fileName);
            $files[] = 'images/'.$fileName;
            info($files);
        }
        $product = new Product([
            'name' => $request->name,
            'price' => $request->price,
            'image' => implode('|', $files),
        ]);
        $product->save();
        info($product);
        $product->categories()->attach($category);
        
        return $product;
    }
    public function update(Request $request)
    {
        info($request->image);
        $files = [];
        $product = Product::find($request->id);
        $request->validate([
            'name' => ['required', Rule::unique('products')->ignore($product->id)],
            'price' => ['required'],
            'category' => ['required'],
            
        ]);
        if($request->hasFile('image')){
            $request->validate([
                'image.*' => 'mimes:jpg,png,jpeg|max:300'
            ]);

            $images = explode("|", $product->image);
            foreach ($images as $image) {
                $filePath = "storage/".$image;
                unlink($filePath);
            }

            foreach ($request->file('image') as $image) {
                $fileName = rand(1000,10000).'.'.$image->extension();
                Storage::putFileAs('public/images', $image, $fileName);
                $files[] = 'images/'.$fileName;
            }

        }
        $product->name = $request->name;
        $product->price = $request->price;
        if($request->hasFile('image')){
            $product->image = implode("|", $files);
        }else{

            $product->image = implode("|", $request->image);
        }
        $request->category = explode(',', $request->category);
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
        $images = explode("|", $product->image);
            foreach ($images as $image) {
                $filePath = "storage/".$image;
                unlink($filePath);
            }
        return $product->delete();
    }
}
