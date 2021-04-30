<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses;
use App\Models\Categories;
use App\Models\ProductHasCat;
use App\Services\Categories\CategoriesStoreData;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::table('categories')->get();
        return Responses::Success("Categories successfully redeemed!", $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CategoriesStoreData::run($request->all());
        return Responses::Success("Category created with sucess!", $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = DB::table('categories')->where('id',  $id)->get();
        return Responses::Success("Category successfully redeemed by ID!", $category);
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

        DB::table('categories')->updateOrInsert(
            ['id' => $id],
            [
                'name' => $data['name'],
            ]
        );

        return Responses::Success("Category updated with sucess!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $relationships = ProductHasCat::where('id_category', $id)->delete();
        Categories::find($id)->delete();

        return Responses::Success("Category {$id} deleted! {$relationships} deleted relationships!", $relationships);
    }
}
