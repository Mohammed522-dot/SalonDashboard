<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use Facade\FlareClient\Http\Response;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MyAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'name'=>'required|max:100|min:5',
            'phone' => 'required|unique:users|regex:/(971)[0-5]{9}/',
            'email'=>'unique:App\Models\User|email',
            // 'address'=>'required|max:100|min:5',
            // 'age'=>'required|min:10|numeric',
            'password' => 'required',
        ]
);

if ($validator->fails()) {
        return $this->sendError($validator->errors(),['en'=>"Invalid Data ",'ar'=>"البيانات غير صحيحة تاكد من تحقق البيانات"],422);
}
        $request->request->add(['role'=>'normal','password'=>bcrypt($request->all()['password'])]);
        $input = $request->all();
        // $input>
        // $input['password'] = bcrypt($input['password']);
        // $input['role']='user';
        $user = new User($input);
        // $randnum = rand(1000,9999);

        // $msg="مرحبا بك في تطبيق ديسكاونت رمز التحقق الخاص بك هو  "."%0a".$randnum."%0a";

        // $msg="مرحبا بك في تطبيق ديسكاونت رمز التحقق الخاص بك هو  "."%0a <strong>".$randnum."<\strong> %0a   ";
        // $response = Http::get("https://mazinhost.com/smsv1/sms/api?action=send-sms&api_key=bXVzdGFmYTc5Okg4eUxXR1JpbE1POA==&to=".$request->phone."&from=Makank&sms=".$msg);
        try{
        // $response = Http::get("https://mazinhost.com/smsv1/sms/api?action=send-sms&api_key=cGguZGlzY291bnQuc2RAZ21haWwuY29tOkxEbDZaI29VM1I=&to=".$request->phone."&from=shayoub&sms=".$msg."&unicode=1");

        if($response =200)
        {
            // $user->otp_code=$randnum;
            $user->save();
            $success['name'] =  $user->name;
            return $this->sendResponse($success, ['en'=>'User register successfully.','ar'=>'تم التسجيل بنجاح ']);
        }
    }catch(Exception $ex){
           return $ex;
    }
        // $success['token'] =  $user->createToken('MyApp')->accessToken;
        return $this->sendError(__('message.error.otp'),['otp_code'=>'invalid OTP Code ']);

}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {


        $validator=Validator::make($request->all(),[
            'phone' => 'required|regex:/(971)[0-9]{9}/',
            'password' => 'required',
            // 'token_firebase'=>'required'

        ]
);

if ($validator->fails()) {
    return $this->sendError("validation Erros",$validator->errors(),422);
}
        if(Auth::attempt(['phone' => $request->phone, 'password' => $request->password,'otp_code'=>null])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('Wow')->accessToken;
            $success['name'] =  $user->name;
            // $user->token_firebase = $request->token_firebase;

            // if($user->token_firebase)
            // $this->addToTopec('broadcast',$user->token_firebase);


            return $this->sendResponse($success, 'User login successfully.');

    }
    return $this->sendError(null,['en'=>"Invalid Data ",'ar'=>"البيانات غير صحيحة تاكد من تحقق البيانات"],409);

}

public function verify(Request $request)
{

    $validator=Validator::make($request->all(),[
        'phone' => 'required|regex:/(249)[0-9]{9}/',
        'otp_code' => 'required|size:4',
        'token_firebase'=>'required'
    ]
);

if ($validator->fails()) {
return $this->sendError($validator->errors(),['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],422);
}
    if($user=User::where('otp_code',$request->otp_code)->where('phone',$request->phone)->first()){
        $user->otp_code=null;
        $user->phone_verified_at=Carbon::now();
        $user->token_firebase=$request->token_firebase;
        $user->save();

        if($user->token_firebase)
        $this->addToTopec('broadcast',$user->token_firebase);

        $success['token']= $user->createToken('Discount')->accessToken;
        $success['user'] =  $user;
        return $this->sendResponse($success, ['en'=>'User login successfully.','ar'=>'تم تسجيل الدخول بنجاح ']);

}
return $this->sendError(['otp_code'=>'invalid OTP Code '],['en'=>"Invalid Data ",'ar'=>"البيانات غير صحيحة "],409);
        // return response()->json(['error' => 'invalid verify code please check valid number '], 409);
}




public function resend(Request $request){
    $phone= $request->phone;
    $randnum = rand(1000,9999);
    $user = User::where('phone',$phone)->first();
    if($user !=null){
    $msg="مرحبا بك في تطبيق ديسكاونت رمز التحقق الخاص بك هو  "."%0a".$randnum."%0a";
    $response = Http::get("https://mazinhost.com/smsv1/sms/api?action=send-sms&api_key=cGguZGlzY291bnQuc2RAZ21haWwuY29tOkxEbDZaI29VM1I=&to=".$phone."&from=shayoub&sms=".$msg."&unicode=1");
    if($response->ok()){
        $user->otp_code=$randnum;
        $user->save();
        return $this->sendResponse(['phone'=>$phone],__('message.otp'));
    }
    }
    return $this->sendError(__('message.error.otp'),['otp_code'=>'invalid OTP Code ']);
}


public function testSms(){
    $phone='249903112270';

    $randnum = rand(1000,9999);

    $msg="مرحبا بك في تطبيق ديسكاونت رمز التحقق الخاص بك هو  "."%0a".$randnum."%0a";
    $response = Http::get("https://mazinhost.com/smsv1/sms/api?action=send-sms&api_key=cGguZGlzY291bnQuc2RAZ21haWwuY29tOkxEbDZaI29VM1I=&to=".$phone."&from=shayoub&sms=".$msg."&unicode=1");

    return $response->body();
}


}
