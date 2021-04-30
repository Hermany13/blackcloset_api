<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Responses;
use App\Services\Colors\ColorsStoreData;
use DB;
use Illuminate\Http\Request;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = DB::table('colors')->get();
        return Responses::Success("Colors successfully redeemed!", $colors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ColorsStoreData::run($request->all());
        return Responses::Success("Color created with sucess!", $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $color = DB::table('colors')->where('id',  $id)->get();
        return Responses::Success("Color successfully redeemed by ID!", $color);
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

        DB::table('colors')->updateOrInsert(
            ['id' => $id],
            [
                'label' => $data['label'],
                'hexcode' => $data['hexcode']
            ]
        );

        return Responses::Success("Color updated with sucess!");
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
