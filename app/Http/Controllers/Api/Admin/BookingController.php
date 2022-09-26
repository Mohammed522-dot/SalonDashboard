<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Booking\Boking;
use App\Models\Booking;
use App\Models\Order;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth('api')->user()->role == "admin"){         
        $bookings=Boking::collection(Booking::orderByDesc('created_at')->get());
        return $this->sendResponse($bookings, ['en'=>' Orders List','ar'=>' ثائمة الطلبات' ]);
        }else{
            $bookings=Boking::collection(Booking::where('salon_id',auth('api')->user()->salone_id)->orderByDesc('created_at')->get());
            return $this->sendResponse($bookings, ['en'=>' Orders List','ar'=>' ثائمة الطلبات' ]);    
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
        $order=Booking::findOrFail($id);
        $order->status_id = 1;//$request->status_id;
        $order->save();

        $messaging = app('firebase.messaging');

        $title = "استلام طلب" ;
        $body = "تمت مراجعة الطلب الخاص بك سيتم الواصل معك للاستلام ";

        $token=$order->user->token_firebase ;//'fkuAG5njQlq4-GO8mL92jw:APA91bEp5aqkYm3zGT7KMN2GMMIKSsL8315YUHtp6giqLNabrk6VxibLOQodO9xkUFGCEzThw6P6RQh730fiKpK27tu11uST3F5bBQXNlv1KobqYOEPenDnQZnPEZkpXFC1FLVWJrRkj';
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create($title,$body))->withData(['test' => 'hi ']);
        $msg=$messaging->send($message);


        return $order;
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
