<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        // dd($message);exit;
        $result=$this->filterData($result);

        $result=$this->sortData($result);

        if(request()->has('admin')){
            $result=$this->paginate($result);
        }


    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['errors'] = $errorMessages;
        }


        return response()->json($response, $code);
    }



    protected function sortData($collection){
        if(request()->has('sort_by')){
          //  $attribute=$transformer::originalAttribute(request()->sort_by);
            $collection=$collection->sortBy->{request()->sort_by};

        }

        return $collection;

    }

    protected function filterData($collection)
    {
        foreach(request()->query() as $query =>$value){
            // $attribute=$transformer::originalAttribute($query);

            if(isset($query,$value) && $query !='sort_by' && $query !='admin' && $query !='page'){
                $collection=$collection->where($query,$value);
            }
        }

        return $collection;
    }


    protected function paginate($collection){

        $role=[
        'pre_page'=>'integer|min:2|max:50',
        ];



        $page=LengthAwarePaginator::resolveCurrentPage();

        $prePage=10;
        if(request()->has('pre_page')){
            $prePage=(int) request()->pre_page;
        }
        $result=$collection->slice(($page-1)*$prePage,$prePage)->values();

        $paginated=new LengthAwarePaginator($result,$collection->count(),$prePage,$page,[
        'path'=>LengthAwarePaginator::resolveCurrentPage(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;

     }


     protected function addToTopec($topicName,$token){
        $messaging = app('firebase.messaging');
        try{
            $result =$messaging->subscribeToTopic($topicName,$token);
           return true;
        }catch(Exception $ex){
            return false;
        }
     }


     protected function sendToPrivate($title,$body,$token,$date=[]){

        try{
            $messaging = app('firebase.messaging');
            $message = CloudMessage::withTarget('token', 'fG9WnuL0RdugX8Up3zTZei:APA91bE5lRtuNQCV_WYAbI3aDGiMkRjHFx6KcosjmA55lT8Ig16FY5W4a0777pSeXa2a0EwmbbpRfnNZNXes3-8qgWgCu2r0qfVTVboKswkwog915JSC80m4Z_ZxYJ-_c2TJJAADU49A')
            ->withNotification(Notification::create($title,$body))->withData($date);
            $msg=$messaging->send($message);
            return true;

        }catch(Exception $ex){
            return false;
        }

     }

     protected function sendToTopic($title,$body,$topicName,$date=[]){

        try{
            $messaging = app('firebase.messaging');
            $message = CloudMessage::withTarget('topic', $topicName)
            ->withNotification(Notification::create($title,$body))->withData($date);
            $msg=$messaging->send($message);
            return true;

        }catch(Exception $ex){
            return false;
        }

     }


}
