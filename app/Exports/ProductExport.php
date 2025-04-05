<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select('title', 'slug', 'image', 'cat_id', 'sup_id', 'code', 'place', 'route', 'buy_date', 'expire_date', 'buying_price', 'selling_price', 'qty', 'status')->get();
    }
}
