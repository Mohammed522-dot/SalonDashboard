<?php

namespace App\Http\Controllers\Api\Drug;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;

class DrugOperationController extends Controller
{

 public function changeActive($id){
    $drug=Drug::findOrFail($id);

    $drug->active=!$drug->active;

    $drug->save();
    return ["activated"=>$drug->active];

 }
    //
}
