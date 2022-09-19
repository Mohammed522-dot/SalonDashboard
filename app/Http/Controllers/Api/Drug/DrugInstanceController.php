<?php

namespace App\Http\Controllers\Api\Drug;

use App\Http\Controllers\Controller;
use App\Http\Resources\DrugsCollection;
use App\Models\Drug;
use Illuminate\Http\Request;

class DrugInstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Drug $drug)
    {
        $drugs=new DrugsCollection(Drug::where('nameScinces_id',$drug->nameScinces_id)->where('id','!=',$drug->id)->where('medicinesection_id',$drug->medicinesection_id)->get());
        return $this->sendResponse($drugs, ['en'=>' Drugs List','ar'=>' ثائمة الادوية' ]);
    }

}
