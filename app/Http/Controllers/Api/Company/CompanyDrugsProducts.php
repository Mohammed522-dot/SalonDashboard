<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\DrugsCollection;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyDrugsProducts extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        $drugs=$company->drugs;
        return $this->sendResponse(new DrugsCollection($drugs), ['en'=>' Drugs List','ar'=>'ثائمة الاوية']);
    }

}
