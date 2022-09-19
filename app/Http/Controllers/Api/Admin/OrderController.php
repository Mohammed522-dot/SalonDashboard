<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderCollection;
use App\Models\Order;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drugs=new OrderCollection(Order::orderByDesc('created_at')->get());
        return $this->sendResponse($drugs, ['en'=>' Orders List','ar'=>' ثائمة الطلبات' ]);
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
        $order=Order::findOrFail($id);
        $order->status_id = 1;//$request->status_id;
        $order->save();

        $messaging = app('firebase.messaging');

        $title = "استلام طلب" ;
        $body = "تمت مراجعة الطلب الخاص بك سيتم الواصل معك للاستلام ";

        $token= $order->user->token_firebase ;//'fkuAG5njQlq4-GO8mL92jw:APA91bEp5aqkYm3zGT7KMN2GMMIKSsL8315YUHtp6giqLNabrk6VxibLOQodO9xkUFGCEzThw6P6RQh730fiKpK27tu11uST3F5bBQXNlv1KobqYOEPenDnQZnPEZkpXFC1FLVWJrRkj';
        $message = CloudMessage::withTarget('token', "ewXjmpdGT46KjNasoTtiez:APA91bFTfQ6z4cXufWeza487po6B7HzOIX12MeuZ-adEu6n7hykJ1TPd6Si5tlMbi6h6laTPHfUT2moT_tcLRGyYfXf2_IAzUXX-SFXVMX8qaOL8MmOqZP3j5wLPmqOAleLNeiBu8I5T")
            ->withNotification(Notification::create($title,$body))->withData(['انيكك' => 'باطل ']);
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
