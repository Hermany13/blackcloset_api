<?php

namespace App\Services\Products;

use App\Models\Products;

class ProductsStoreData
{
    public static function run(array $data)
    {
            Products::create([
                'name' => $data['name'],
                'price' => $data['price'],
                'size' => $data['size'],
                'color' => $data['color'],
                'category' => $data['category'],
                'availability' => $data['availability'],
                'status' => $data['status'],
                'description' => $data['description'],
                'image' => $data['image'],
            ]);
    }
}

