<?php

namespace App\Services\ProductStock;

use App\Models\ProductStock;

class ProductStockStoreData
{
    public static function run(array $data)
    {
        ProductStock::create([
            'id_product' => $data['id_product'],
            'id_color' => $data['id_color'],
            'id_size' => $data['id_size'],
            'quantity' => $data['quantity'],
            'img_color' => $data['img_color'],
            'status' => $data['status'],
        ]);
    }
}
