<?php

namespace App\Http\Controllers\Api\Admin\Salon;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCollection;
use App\Models\Company;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class SalonServicesController extends Controller
{
    public function index($salonId)
    {
        $salon = Company::find($salonId);

        if(auth('api')->user()->role == "admin")
        $services = new ServiceCollection(Service::all());
        else
        $services = new ServiceCollection($salon->services);
        
        return $this->sendResponse($services, ['en'=> 'Services','ar'=> 'ثائمة الا  دوية' ]);
    }
    

    public function store($id,Request $request)
    {

        if($request->icons){
            $name=time().'.'.explode('/',explode(':',substr($request->icons,0,strpos($request->icons,';')))[1])[1];
            Image::make($request->icons)->save(public_path('/icon'.DIRECTORY_SEPARATOR.'Drugs/').$name);
            $request->merge(['icons'=>$name]);

            // $oldProfile=public_path('image/profile/').$currentPhoto;
            // if(file_exists($oldProfile))
            // @unlink($oldProfile);
        }


        $service = Service::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'image'=>$request->icons,
            'price'=>$request->price,
            'time_service'=>$request->time_services,
            'servicetype_id' =>  $request->servicetype_id,
            'salons_id' => $id
        ]);




        return $this->sendResponse($service, ['en'=>' Drugs List','ar'=>' ثائمة الادوية' ]);

    }

    public function update(Request $request, $id)
    {
        $services=  Service::findOrFail($id);
        $services->fill($request->only([
            'name',
            'description',
            'servicetype_id',
            'price',
        ]));

        // $medicines->name = $request->name;
        // $medicines->description = $request->description;

        if($services->isClean())
        return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],'Sory u should specific diffrent Values',422);
        $services->save();
        return $services;

    }


     

}
