<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHasCat extends Model
{
    use HasFactory;

    protected $table = 'product_has_cat';

    protected $fillable = [
        'id_product',
        'id_category'
    ];
}
