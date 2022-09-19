<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderOrderDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // return $order;
        $order= Order::find($id);
        $ordersDetalis = $order //->drugs()  //->with('drugs')
        ->with(['products','drugs','prescriptions'])
        ->get()
        ->where('id',$order->id)->first();

        return $ordersDetalis;

    }


}
