<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\Booking\Boking;
use App\Http\Resources\Offers\OffersResources;
use App\Models\Booking;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offersOrders=Boking::collection(Booking::with('offer')->get());
        return $offersOrders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=$this->validate($request,[
            'note' => 'required',
            'address' => 'required',
            'long' => 'required',
            'lat' => 'required',
            'offer_id' => 'required',
            'amount'=> 'required'
        ]
    ); //

    $order=Booking::create([
        'note'=>$request->note,
        'address'=>$request->address,
        'long'=>$request->long,
        'lat'=>$request->lat,
        'user_id'=>auth()->user()->id,
        'offer_id'=>$request->offer_id,
        'amount'=>$request->amount
    ]);

    DB::commit();

    return $this->sendResponse($order,["success"]);
    try{
        DB::beginTransaction();

    }catch(Exception $ex){
        DB::rollBack();

    }
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
