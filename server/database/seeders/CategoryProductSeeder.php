<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'product_id' => 1,
                'category_id' => 1
            ],
            [
                'product_id' => 2,
                'category_id' => 2
            ],
            [
                'product_id' => 3,
                'category_id' => 3
            ],
            [
                'product_id' => 1,
                'category_id' => 2
            ],

        ];
        CategoryProduct::insert($data);    
    }
}
