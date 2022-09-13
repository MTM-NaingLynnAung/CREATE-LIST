<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\CategoryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        if(request('search')){
            return Category::where('name', 'LIKE', '%'. request('search') .'%')->orderBy('id', 'desc')->paginate(2);
        }
       return Category::orderBy('id', 'desc')->paginate(5);
    }
    public function show(Category $category){
        return $category;
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $category = new Category([
            'name' => $request->name
        ]);
        $category->save();
        return $category;
    }
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $category->name = $request->name;
        $category->update();
        return $category;
    }
    public function export(){
        return Excel::download(new CategoryExport, 'category.csv');
    }
    public function destroy(Category $category)
    {
        return $category->delete();
    }
}
