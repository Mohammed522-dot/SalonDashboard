<?php

namespace App\Http\Controllers\Api\Medicinesection;

use App\Http\Controllers\Controller;
use App\Http\Resources\DrugsCollection;
use App\Models\Medicinesection;
use Illuminate\Http\Request;

class MedicinesectionDrugsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Medicinesection $medicinesection)
    {
        $drugs=$medicinesection->drugs;
        return $this->sendResponse(new DrugsCollection($drugs), ['en'=>' Drugs List','ar'=>'ثائمة الاوية']);
    }
}
