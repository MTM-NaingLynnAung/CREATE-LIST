<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $products = Product::all();
        return $products;
    }
    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->description,
            $product->price,
        ];
    }
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Price'
        ];
    }
}
