<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'title'         => $row[0],
            'slug'          => $row[1],
            'image'         => $row[2],
            'cat_id'        => $row[3],
            'sup_id'        => $row[4],
            'code'          => $row[5],
            'place'         => $row[6],
            'route'         => $row[7],
            'buy_date'      => $row[8],
            'expire_date'   => $row[9],
            'buying_price'  => $row[10],
            'selling_price' => $row[11],
            'qty'           => $row[12],
            'status'        => $row[13],
        ]);
    }
}
