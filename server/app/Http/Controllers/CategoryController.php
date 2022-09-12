<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products', 'children'])->get();
        return response()->json(CategoryResource::collection($categories));
    }
    public function store(Request $request)
    {
    $isExit = Category::where('name', $request->name)->exists();
       if(!$request->sub_name){
            if(!$isExit){
                $category = new Category([
                    'name' => $request->name,
                ]);
            }else{
                $category = Category::where('name', $request->name)->first();
            }
       }else{
            $parent = Category::where('name', $request->name)->first();
            $isExit = Category::where('name', $request->sub_name)->first();
            if(!$isExit){
                $category = new Category([
                    'name' => $request->sub_name,
                    'parent_id' => $parent->id,
                ]);
            }else{

                $category = Category::where('name', $request->sub_name)->first();
            }
       }
       $category->save();
       return $category;
    }
    public function update(Request $request, Category $category)
    {
        $isExit = Category::where('name', $request->sub_name)->exists();
        if(!$isExit){
            $category->name = $request->sub_name;
            $category->update();
        }
       return $category;
    }
    public function destroy(Category $category)
    {
        return $category->delete();
    }
}
