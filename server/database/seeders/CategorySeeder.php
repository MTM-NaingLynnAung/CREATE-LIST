<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $categories = [
        [
            'parent_id' => 1,
            'name' => 'Electronics',
        ],
        [
            'parent_id' => 1,
            'name' => 'Mobile Phone',
        ],
        [
            'parent_id' => 1,
            'name' => 'Tablet',
        ]
        ];
        foreach($categories as $category){
            Category::create($category);
        }
    }
}
