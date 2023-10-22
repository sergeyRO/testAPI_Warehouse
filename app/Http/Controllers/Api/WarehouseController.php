<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouses;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Просмотреть список складов
        return response()->json([
            'result' => Warehouses::all(),
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouses  $warehouses
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouses $warehouses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouses  $warehouses
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouses $warehouses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warehouses  $warehouses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouses $warehouses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warehouses  $warehouses
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouses $warehouses)
    {
        //
    }
}
