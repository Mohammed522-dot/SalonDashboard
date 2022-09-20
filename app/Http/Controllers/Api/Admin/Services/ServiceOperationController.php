<?php

namespace App\Http\Controllers\Api\Drug;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceOperationController extends Controller
{

 public function changeActive($id){
    $service=Service::findOrFail($id);

    $service->active=!$service->active;

    $service->save();
    return ["activated"=>$service->active];

 }
    //
}
