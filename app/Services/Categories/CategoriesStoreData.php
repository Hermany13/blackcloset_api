<?php

namespace App\Services\Categories;

use App\Models\Categories;
use Str;

class CategoriesStoreData
{
    public static function run(array $data)
    {
        Categories::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'], '-'),
        ]);
    }
}
