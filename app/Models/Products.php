<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products_data';

    protected $fillable = [
        'name',
        'price',
        'size',
        'color',
        'category',
        'availability',
        'status',
        'description',
        'image',
    ];
}
