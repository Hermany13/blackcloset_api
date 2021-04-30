<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Responses;
use Illuminate\Http\Request;
use App\Services\ProductStock\ProductStockStoreData;
use DB;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ProductStockStoreData::run($request->all());
        DB::table('products_data')->updateOrInsert(
            ['id' => $request->get('id_product')],
            [
                'status' => 1
            ]
        );
        return Responses::Success("Stock created with sucess!", $request->all());
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

        $stock = DB::table('product_stock')->where('id_product', $product->id)->get();

        $auxStock = [];
        foreach ($stock as $s) {
            $auxS = [];
            $auxS['quantity'] = $s->quantity;
            $auxS['image'] = $s->img_color;
            $auxS['color'] = DB::table('colors')->where('id', $s->id_color)->get()[0];
            $auxS['size'] = DB::table('sizes')->where('id', $s->id_size)->get()[0];
            array_push($auxStock, $auxS);
        }

        $product->stock = $auxStock;

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

        DB::table('product_stock')->updateOrInsert(
            ['id' => $id],
            [
                'img_color' => $data['img_color'],
            ]
        );

        return Responses::Success("Product stock updated with sucess!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
