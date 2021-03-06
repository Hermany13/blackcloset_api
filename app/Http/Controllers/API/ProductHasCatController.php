<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Responses;
use App\Services\Categories\ProductHasCatStoreData;
use Illuminate\Http\Request;

class ProductHasCatController extends Controller
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
    public function store(Request $request, $id)
    {
        if (array_key_exists("categories", $request->all())) {
            $categories_ids = $request->get('categories');
            foreach ($categories_ids as $cat_id) {
                $data['id_category'] = $cat_id;
                $data['id_product'] = $id;
                ProductHasCatStoreData::run($data);
            }
            return Responses::Success("Product and categories related with sucess!", $request->all());
        }

        $data['id_category'] = $request->get('id_category');
        $data['id_product'] = $id;
        ProductHasCatStoreData::run($data);
        return Responses::Success("Product and category related with sucess!", $request->all());
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
        //
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
