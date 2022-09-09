<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillabe = [
        'parent_id',
        'name'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products', 'product_id', 'category_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
