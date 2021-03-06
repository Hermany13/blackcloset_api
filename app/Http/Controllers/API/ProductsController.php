<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses;
use App\Models\Products;
use App\Services\Products\ProductsStoreData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO MOVE GET BY ID TO store METHOD
        // if ($id != "") {
        //     $products = DB::table('products_data')->where('id',  $id)->get();
        //     return Responses::Success("Products successfully redeemed by ID!", $products);
        // }

        $products = DB::table('products_data')->get();

        $auxProd = [];
        foreach ($products as $product) {
            $relationships = DB::table('product_has_cat')->where('id_product', $product->id)->get();
            $auxCat = [];
            foreach ($relationships as $relation) {
                array_push($auxCat, DB::table('categories')->where('id', $relation->id_category)->get()[0]);
            }
            $product->categories = $auxCat;
            array_push($auxProd, $product);
        }

        return Responses::Success("Products successfully redeemed!", $auxProd);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (env('FAKE_REQUEST', 0) == 0) {
            ProductsStoreData::run($request->all());
            return Responses::Success("Product created with sucess!", $request->all());
        } else {
            $request = Products::factory()->make()->toArray();
            ProductsStoreData::run($request);
            return Responses::Success("Product created with sucess!", $request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = DB::table('products_data')->where('id',  $id)->get()[0];
        $relationships = DB::table('product_has_cat')->where('id_product', $product->id)->get();
        $auxCat = [];
        foreach ($relationships as $relation) {
            array_push($auxCat, DB::table('categories')->where('id', $relation->id_category)->get()[0]);
        }
        $product->categories = $auxCat;

        return Responses::Success("Product successfully redeemed!", $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::table('products_data')->updateOrInsert(
            ['id' => $id],
            [
                'name' => $data['name'],
                'slug' => $data['slug'],
                'price' => $data['price'],
                'offerPrice' => $data['offerPrice'],
                'availability' => $data['availability'],
                'status' => $data['status'],
                'parcels' => $data['parcels'],
                'description' => $data['description'],
                'image' => $data['image'],
                'isOffer' => $data['isOffer'],
            ]
        );

        return Responses::Success("Product updated with sucess!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('products_data')->updateOrInsert(
            ['id' => $id],
            ['status' => 0]
        );

        return Responses::Success("Product disabled with sucess!");
    }
}
