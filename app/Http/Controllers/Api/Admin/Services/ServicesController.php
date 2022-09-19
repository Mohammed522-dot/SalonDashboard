<?php

namespace App\Http\Controllers\Api\Admin\Services;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompaniesCollection;
use App\Http\Resources\ServiceCollection;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    //

    public function index()
    {


        if(request()->has('admin'))
        $services=new ServiceCollection(Service::all());
        else
        $services=new ServiceCollection(Service::where('active',true)->get());

        return $this->sendResponse($services, ['en'=>'SErvices ','ar'=>' ثائمة الادوية' ]);
    }


}
