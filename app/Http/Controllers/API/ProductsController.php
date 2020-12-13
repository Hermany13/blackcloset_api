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
    public function index(Request $request)
    {
        $category = $request->input('category');
        $color = $request->input('color');
        $availability = $request->input('availability');
        $status = $request->input('status');
        $id = $request->input('id');

        if($category) {
            $products = DB::table('products_data')->where('category',  $category)->get();
            return Responses::Success("Products successfully redeemed by category!", $products);
        }

        if($color) {
            $products = DB::table('products_data')->where('color',  $color)->get();
            return Responses::Success("Products successfully redeemed by color!", $products);
        }


        if($availability != "") {
            $products = DB::table('products_data')->where('availability',  $availability)->get();
            return Responses::Success("Products successfully redeemed by availability!", $products);
        }

        if($status != "") {
            $products = DB::table('products_data')->where('status',  $status)->get();
            return Responses::Success("Products successfully redeemed by status!", $products);
        }

        if($id != "") {
            $products = DB::table('products_data')->where('id',  $id)->get();
            return Responses::Success("Products successfully redeemed by ID!", $products);
        }
            
        $products = DB::table('products_data')->get();
        return Responses::Success("Products successfully redeemed!", $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(env('FAKE_REQUEST', 0) == 0) {
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
        //
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
                'price' => $data['price'],
                'size' => $data['size'],
                'color' => $data['color'],
                'category' => $data['category'],
                'availability' => $data['availability'],
                'status' => $data['status'],
                'description' => $data['description'],
                'image' => $data['image']
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
