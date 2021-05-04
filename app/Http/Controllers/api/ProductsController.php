<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Responses;
use App\Models\Products;
use App\Services\Categories\ProductHasCatStoreData;
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
        $products = DB::table('products_data')->where('status', '1')->get();

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

    public function latest()
    {
        $products = Products::orderBy('id', 'DESC')->paginate(6);

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
        $categories_ids = $request->get('categories');
        unset($request['categories']);

        ProductsStoreData::run($request->all());
        $id = DB::table('products_data')->orderBy('id', 'desc')->first();
        foreach ($categories_ids as $cat_id) {
            $data['id_category'] = $cat_id;
            $data['id_product'] = $id->id;
            ProductHasCatStoreData::run($data);
        }
        return Responses::Success("Product created with sucess!", $request->all());
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

        if ($product->status == 0) {
            $error['status'] = 'Error';
            $error['message'] = 'Produto não existe';
            return $error;
        }

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
                'parcels' => $data['parcels'],
                'description' => $data['description'],
                'image' => $data['image'],
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

    public function setOffer(Request $request, $id)
    {
        $data = $request->all();

        DB::table('products_data')->updateOrInsert(
            ['id' => $id],
            [
                'isOffer' => $data['isOffer'],
                'offerPrice' => $data['offerPrice']
            ]
        );

        return Responses::Success("Product offer init with sucess!");
    }
}
