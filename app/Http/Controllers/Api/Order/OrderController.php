<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drugs=new OrderCollection(auth()->user()->orders);
        return $this->sendResponse($services, ['en'=>' Orders List','ar'=>' ثائمة الطلبات' ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // logger(isset($request->products[0]['product_id'])==true?$request->products[0]['product_id']:"nullaa");

        $validator=$this->validate($request,[
            'note' => 'required',
            'address' => 'required',
            'long' => 'required',
            'lat' => 'required',
            'products.*.amount' => 'required',
            'products.*.product_id' => 'required_without:products.*.drug_id|exists:products,id',
            'drugs.*.drug_id' => 'required_without:products.*.product_id|exists:drugs,id',
            'prescriptions.*.recommendation' => 'required',
            'prescriptions.*.images' => 'required',
        ]
    ); //

    // if ($validator->fails()) {
    //     return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],$validator->errors(),422);
    //     }
    // return  $request;

    try{
        $orderData = $request;
        DB::beginTransaction();
        // $totalPrice=0;
        // foreach($orderData['orderItems'] as $orderItem){
        //     // $item= Item::find($orderItem['item_id']);
        //     // // if($item){
        //     // //     $totalPrice+=$item->price * $orderItem['quantity'];
        //     // // }
        // }

        $order=Order::create([
            'note'=>$request->note,
            'address'=>$request->address,
            'long'=>$request->long,
            'lat'=>$request->lat,
            'user_id'=>auth()->user()->id
        ]);

        logger(isset($orderData->products[0]['product_id'])==true?$orderData->products[0]['product_id']:"aaa");

        // return $orderData;
    // foreach ($orderData->products as $product) {
    //     $order->orderdetails()->create([
    //         'amount'=>isset($product['amount'])==true?$product['amount']:null,
    //         'product_id'=>isset($product['product_id'])==true?$product['product_id']:null,
    //         'drug_id'=>isset($product['drug_id'])==true?$product['drug_id']:null

    //     ]);
    // }

    //  $newOrder=[];
    // foreach ($orderData->products as $product) {
    //     $order->orderdetails()->create([
    //         'amount'=>isset($product['amount'])==true?$product['amount']:null,
    //         'product_id'=>isset($product['product_id'])==true?$product['product_id']:null,
    //     ]);
    // }

      $order->products()->sync($orderData->products);
      $order->drugs()->sync($orderData->drugs);


    foreach ($orderData->prescriptions as $orderItem) {
        $order->prescriptions()->create([
            'image'=>$orderItem['images'],
            'recommendation'=>$orderItem['recommendation']
        ]);
    }
        DB::commit();
        // logger($totalPrice);
        return $this->sendResponse($order, ['en'=>' Order Created Successfuly ','ar'=>'تم ارسال الطلب بنجاح ' ]);
    }catch(Exception $ex){
        logger($ex->getMessage());
        DB::rollBack();
        return $ex->getMessage();
        // return $this->sendError($ex->getMessage(),500);

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
        $order= Order::findOrFail($id);
        return $this->sendResponse(new OrderResource($order), ['en'=>' Order Dtails ','ar'=>'نفاصيل الطلب ' ]);
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
    public function destroy(Order $order)
    {
        $order->status_id=Order::ORDERCANCEL;

        $order->save();

        return $this->sendResponse(new OrderResource($order), ['en'=>'Order Deleted ','ar'=>'تم حذ الطلب بنجاح  ' ]);
    }


    public function changeActive($id){
        $order=Order::findOrFail($id);
        $order->active=!$order->active;
        $order->save();
        return ["activated"=>$order->active];

    }
}
