<?php

namespace App\Http\Controllers\Api\Admin\ServiceType;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServicesTypeController extends Controller
{
    public function index()
    {
        $services = ServiceType::all();
        return $this->sendResponse($services, ['en'=>' Companies List','ar'=>'ثائمة الشركات']);
    }
}
