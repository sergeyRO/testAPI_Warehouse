<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Motion;
use App\Models\Order_items;
use App\Models\Orders;
use App\Models\Stocks;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create model Motion.
     *
     *
     */
    protected function motion($warehouse_id,$product_id,$order_id,$action,$remain)
    {
        Motion::create([
            'order_id'=>$order_id,
            'product_id'=>$product_id,
            'warehouse_id'=>$warehouse_id,
            'action'=>$action,
            'remain'=>$remain]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Получить список заказов (с фильтрами и настраиваемой пагинацией) метод GET
        //$page = $request['page'];
        //$skip = $request['skip'];

        $limit = $request['limit'];
        $status = $request['status'];
        $customer = $request['customer'];
        $created_at = $request['created_at'];
        $completed_at = $request['completed_at'];
        $warehouse_id = $request['warehouse_id'];
        $query = Orders::join('warehouses','orders.warehouse_id','=','warehouses.id');
        if(isset($status))
        {
            $query = $query->where('status',$status);
        }
        if(isset($customer))
        {
            $query = $query->where('customer',$customer);
        }
        if(isset($created_at))
        {
            $query = $query->where('created_at',$created_at);
        }
        if(isset($completed_at))
        {
            $query = $query->where('completed_at',$completed_at);
        }
        if(isset($warehouse_id))
        {
            $query = $query->where('warehouse_id',$warehouse_id);
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
        // Создать заказ (в заказе может быть несколько позиций с разным количеством) метод POST
        // Заглушка для warehouse_id.
        // Считаю глупо вписывать в заказ Склад, так как заказ может быть собран с нескольких складов
        // Вернее было б warehouse_id добавить в таблицу Order_items
        $warehouse_id=1;
        $status='active';

        $order_id = Orders::insertGetId(['customer'=>$request->customer,'warehouse_id'=>$warehouse_id,'status'=>$status]);
        foreach ($request->products as $item)
        {
            Order_items::create([
                'order_id'=>$order_id,
                'product_id'=>$item['product_id'],
                'count'=>$item['count']
            ]);
        }
        return response()->json([
            'result' => $order_id,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Обновить заказ (данные покупателя и список позиций, но не статус) метод PUT
        Orders::where('id',$id)->update(['customer'=>$request->customer]);
        Order_items::where('order_id',$id)->delete();

        foreach ($request->products as $item)
        {
            Order_items::create([
                'order_id'=>$id,
                'product_id'=>$item['product_id'],
                'count'=>$item['count']
            ]);
        }

        return response()->json([
            'order'=>Orders::find($id),
            'products' => Orders::find($id)->products,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update status order  the specified resource from storage.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update_state(Request $request,$id)
    {
        // 'Возврат','В обработке','Выполнен') метод PATCH
        // Завершить заказ
        // Отменить заказ
        // Возобновить заказ (перевод из отмены в работу)
        $order = Orders::find($id);

        if($order->status!='completed')
        {
            //Сделать заказ активным, если он закрыт и вернуть на склад stock=count+stock
            if($order->status=='canceled' && $request->status=='active')
            {
                //Делаю кривое решение первый попавшийся склад так как warehouse_id (его не должно быть в заказе) находится не насвоем месте
                //Возврат не понятно куда делать
                $order = Order_items::join('stocks','order_items.product_id','=','stocks.product_id')->where('order_id',$id)->groupBy('stocks.product_id')->get();
                foreach ($order as $item)
                {
                    $stock = Stocks::where('product_id',$item->product_id)->first();
                    Stocks::where('warehouse_id',$stock->warehouse_id)->update(['stock'=>$stock->stock+$item->count]);
                    $this->motion($stock->warehouse_id,$item->product_id,$id,'Возврат',$stock->stock+$item->count);
                }
                Orders::where('id',$id)->update(['status'=>'active']);
                return response()->json([
                    'id' => $id,
                    'result' => 'Статус изменен',
                    'status' => 'active',
                ],200);
            }

            //Закрыть заказ, если он активный
            else if($order->status=='active' && $request->status=='canceled')
            {
                $order = Order_items::join('stocks','order_items.product_id','=','stocks.product_id')
                    ->where('order_id',$id)
                    ->groupBy('stocks.product_id')
                    ->select('*')
                    ->selectRaw('stocks.stock-order_items.count as delta')
                    ->get();
                foreach ($order as $item)
                {
                    if($item->delta<0)
                    {
                        return response()->json([
                            'error' => 'Нет товара на каком либо складе',
                        ],200);
                    }
                }
                foreach ($order as $item)
                {
                    $stock = Stocks::where('product_id',$item->product_id)->first();
                    Stocks::where('warehouse_id',$stock->warehouse_id)->update(['stock'=>$stock->stock-$item->count]);
                    $this->motion($stock->warehouse_id,$item->product_id,$id,'В обработке',$stock->stock-$item->count);
                }
                Orders::where('id',$id)->update(['status'=>'canceled']);
                return response()->json([
                    'id' => $id,
                    'result' => 'Статус изменен',
                    'status' => 'canceled',
                ],200);
            }

            //Выполнить заказ, если он закрытый
            else if($order->status=='canceled' && $request->status=='completed')
            {
                $order = Order_items::join('stocks','order_items.product_id','=','stocks.product_id')->where('order_id',$id)->groupBy('stocks.product_id')->get();
                foreach ($order as $item) {
                    $stock = Stocks::where('product_id', $item->product_id)->first();
                    Stocks::where('warehouse_id', $stock->warehouse_id)->update(['stock' => $stock->stock + $item->count]);
                    $this->motion($stock->warehouse_id,$item->product_id,$id,'Выполнен',$stock->stock);
                }
                Orders::where('id',$id)->update(['status'=>'completed','completed_at'=>Carbon::now()]);
                return response()->json([
                    'id' => $id,
                    'result' => 'Статус изменен',
                    'status' => 'completed',
                ],200);
            }

            else
            {
                return response()->json([
                    'id' => $id,
                    'result' => 'Статус не изменен'
                ],200);
            }
        }
        return response()->json([
            'id' => $id,
            'error' => 'Заказ завершён был уже!',
        ],200);
    }
}
