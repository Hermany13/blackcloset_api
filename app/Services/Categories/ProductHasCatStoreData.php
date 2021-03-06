<?php

namespace App\Services\Categories;

use App\Models\ProductHasCat;

class ProductHasCatStoreData
{
    public static function run(array $data)
    {
        ProductHasCat::create([
            'id_product' => $data['id_product'],
            'id_category' => $data['id_category'],
        ]);
    }
}
