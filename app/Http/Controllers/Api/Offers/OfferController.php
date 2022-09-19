<?php

namespace App\Http\Controllers\Api\Offers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Offers\OffersCollection;
use App\Http\Resources\Offers\OffersResources;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('admin'))
        $offers= Offer::all();
        else
        {
            $currentDate = Carbon::today()->addDay();
            $offers= Offer::where('active',true)->where('endDate','>=',$currentDate)->get();

        }

        return $this->sendResponse(new OffersCollection($offers), ['en'=>' offers List','ar'=>' ثائمة  العروض' ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=> 'required|string|max:191',
            'description'=>'required|string|min:20',
        ]);


        $offer= Offer::create([
            'name'=>$request->name,
            'description'=> $request->description,
            'strDate'=> $request->date,
            'endDate'=> $request->enddate,
            'price'=> $request->price,
            'drug_id'=>$request->drug_id,
            'product_id'=>$request->product_id
        ]);

          return $offer->drugs;
        $old_price = $offer->product  ;

        $title = "عرض جديد" ;
        $body = " الان   ".$offer->name." بسعر : ".$offer->price." بدلا عن  ".$offer->product->price;

        $this->sendToTopic($title,$body,"broadcast",['dataType'=>"Offers"]);

        // $token='fkuAG5njQlq4-GO8mL92jw:APA91bEp5aqkYm3zGT7KMN2GMMIKSsL8315YUHtp6giqLNabrk6VxibLOQodO9xkUFGCEzThw6P6RQh730fiKpK27tu11uST3F5bBQXNlv1KobqYOEPenDnQZnPEZkpXFC1FLVWJrRkj';
        // $message = CloudMessage::withTarget('token', $token)
        //     ->withNotification(Notification::create($title,$body))->withData();
        // $msg=$messaging->send($message);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offers= Offer::findOrFail($id);
        return $this->sendResponse(new OffersResources($offers), ['en'=>' offers List','ar'=>' ثائمة  العروض' ]);
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
        $offer=  Offer::findOrFail($id);

         $offer->fill($request->only([
            'name'=>$request->name,
            'description'=> $request->description,
            'strDate'=> $request->date,
            'endDate'=> $request->enddate,
            'price'=> $request->price,
            'drug_id'=>$request->drug_id,
            'product_id'=>$request->product_id
        ]));


        if($offer->isClean())
        return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],'Sory u should specific diffrent Values',422);

        $offer->save();
        return $offer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medicines=Offer::findOrFail($id);
        $medicines->delete();
        return $medicines;
    }


    public function changeActive($id){
        $offer=Offer::findOrFail($id);
        $offer->active=!$offer->active;
        $offer->save();
    return ["activated"=>$offer->active];

    }
}
