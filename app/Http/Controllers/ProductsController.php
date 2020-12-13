<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses;
use App\Models\Products;
use App\Services\Products\ProductsStoreData;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    //
    public function create(Request $request)
    {
        if(env('FAKE_REQUEST', 0) == 0) {
            ProductsStoreData::run($request->all());
            return Responses::Success("Sucess!", $request->all());
        } else {
            $request = Products::factory()->make()->toArray();
            ProductsStoreData::run($request);
            return Responses::Success("Sucess!", $request);
        }
    }

    public function rescue()
    {
        $products = DB::table('products_data')->get();

        return Responses::Success("Sucess!", $products);
    }
}
