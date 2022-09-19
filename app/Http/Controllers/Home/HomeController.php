<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role == "admin"){
        $booking_count=Booking::where('status_id',0)->count();
        $order_count=0;//Order::where('status_id',0)->count();
        $data=['orders_count'=>$order_count,'booking_count'=>$booking_count];
        return view('home',['data'=>$data]);
        }
        else{
          //  dd(auth()->user()->role);
            $booking_count=Booking::where('user_id',auth()->user()->id)->count();
            $order_count=0;//Order::where('user_id',auth()->user()->id)->count();
            $data=['orders_count'=>$order_count,'booking_count'=>$booking_count];
            return view('home',['data'=>$data]);
        }
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
