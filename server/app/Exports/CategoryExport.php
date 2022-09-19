<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class CategoryExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return $categories;
    }
    // public function __construct($search){
    //     $this->search = $search;
    // }
    // public function query()
    // {
    //     return Category::query()->where('name', $this->search)
    // }
    public function map($category): array
    {
        return [
            $category->id,
            $category->name
        ];
    }
    public function headings(): array
    {
        return [
            'ID',
            'Name'
        ];
    }
}
