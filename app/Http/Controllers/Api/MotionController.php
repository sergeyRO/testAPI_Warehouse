<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Motion;
use Illuminate\Http\Request;

class MotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //просмотра историй изменения остатков товаров
        //$page = $request['page'];
        //$skip = $request['skip'];

        $limit = $request['limit'];
        $order_id = $request['order_id'];
        $product_id = $request['product_id'];
        $warehouse_id = $request['warehouse_id'];
        $action = $request['action'];
        $remain = $request['remain'];
        $created_at = $request['created_at'];

        $query = Motion::join('warehouses','motions.warehouse_id','=','warehouses.id')
            ->join('products','motions.product_id','=','products.id')
            ->join('orders','motions.order_id','=','orders.id');
        if(isset($action))
        {
            $query = $query->where('action',$action);
        }
        if(isset($remain))
        {
            $query = $query->where('remain',$remain);
        }
        if(isset($created_at))
        {
            $query = $query->where('created_at',$created_at);
        }
        if(isset($order_id))
        {
            $query = $query->where('order_id',$order_id);
        }
        if(isset($warehouse_id))
        {
            $query = $query->where('warehouse_id',$warehouse_id);
        }
        if(isset($product_id))
        {
            $query = $query->where('product_id',$product_id);
        }
        /*if(!isset($skip))
        {
            $skip=0;
        }
        if(!isset($page))
        {
            $page=0;
        }*/
        if(!isset($limit))
        {
            $limit=1;
        }
        $query = $query->paginate($limit);
        //$query = $skip($skip)->take($limit)->get();
        return response()->json([
            'result' => $query,
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
     * @param  \App\Models\Motion  $motion
     * @return \Illuminate\Http\Response
     */
    public function show(Motion $motion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Motion  $motion
     * @return \Illuminate\Http\Response
     */
    public function edit(Motion $motion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Motion  $motion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motion $motion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Motion  $motion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motion $motion)
    {
        //
    }
}
