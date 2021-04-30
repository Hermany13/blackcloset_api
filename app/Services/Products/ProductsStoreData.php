<?php

namespace App\Services\Products;

use App\Models\Products;
use Str;

class ProductsStoreData
{
    public static function run(array $data)
    {
        Products::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'], '-'),
            'price' => $data['price'],
            'offerPrice' => $data['offerPrice'],
            'parcels' => $data['parcels'],
            'description' => $data['description'],
            'image' => $data['image'],
            'isOffer' => $data['isOffer'],
        ]);
    }
}
