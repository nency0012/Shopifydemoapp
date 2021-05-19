<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public  function  listOrders(Request $request)
    {
        $orderdata= Order::all();
        return response()->json(['data'=>$orderdata,'message'=>'data get successfully']);
    }

}
