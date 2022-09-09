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
            'parent_id' => null,
            'name' => 'Electronics',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'parent_id' => 1,
            'name' => 'Mobile Phone',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'parent_id' => 1,
            'name' => 'Tablet',
            'created_at' => now(),
            'updated_at' => now()
        ]
        ];
        Category::insert($categories);

    }
}
