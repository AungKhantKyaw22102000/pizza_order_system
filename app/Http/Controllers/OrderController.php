<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // direct order list page
    public function list(){
        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('created_at','desc')
                ->get();
        return view ('admin.order.list',compact('order'));
    }

    // download order list csv
    public function generateCsV() {
        $data = Order::get();
        $fileName = 'orderList.csv';
        $fp = fopen($fileName, 'w+');
        fputcsv($fp, array('User ID', 'User Name', 'Order Code', 'Total Price', 'Order Status'));

        foreach($data as $row){
            fputcsv($fp, array($row->user_id, $row->user->name, $row->order_code, $row->total_price, $row->status));
        }

        fclose($fp);
        $headers = array('Content-Type' => 'text/csv');

        return response()->download($fileName, 'orderList.csv', $headers);
    }

    // sort with ajax status
    public function changeStatus(Request $request){
        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('created_at','desc');

        if($request->orderStatus == null){
            $order = $order->get();
        } else{
            $order = $order->where('orders.status', $request->orderStatus)->get();
        }
        return view('admin.order.list',compact('order'));
    }

    // orderlist
    public function listInfo($orderCode){
        $order = Order::where('order_code',$orderCode)->first();
        $orderList = OrderList::select('order_lists.*','users.name as user_name','products.image as product_image','products.name as product_name')
                    ->leftJoin('users','users.id','order_lists.user_id')
                    ->leftJoin('products','products.id','order_lists.product_id')
                    ->where('order_code',$orderCode)
                    ->get();
        return view('admin.order.productList',compact('orderList','order'));
    }

    // ajax change status
    public function ajaxChangeStatus(Request $request){
        Order::where('id', $request->orderId)->update([
            'status'=>$request->status,
        ]);

        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('created_at','desc')
                ->get();
        return response()->json($order, 200);
    }
}
