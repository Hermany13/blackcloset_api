<?php

namespace App\Services\Colors;

use App\Models\Colors;

class ColorsStoreData
{
    public static function run(array $data)
    {
        Colors::create([
            'label' => $data['label'],
            'hexcode' => $data['hexcode']
        ]);
    }
}
