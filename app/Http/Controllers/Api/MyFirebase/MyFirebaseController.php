<?php

namespace App\Http\Controllers\Api\MyFirebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class MyFirebaseController extends Controller
{
    //

    public function index(){
        $messaging = app('firebase.messaging');

        $token='fkuAG5njQlq4-GO8mL92jw:APA91bEp5aqkYm3zGT7KMN2GMMIKSsL8315YUHtp6giqLNabrk6VxibLOQodO9xkUFGCEzThw6P6RQh730fiKpK27tu11uST3F5bBQXNlv1KobqYOEPenDnQZnPEZkpXFC1FLVWJrRkj';
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create('Title', 'Body'))->withData(['key' => 'value']);
        $msg=$messaging->send($message);

        return $msg;

    }
}
