<?php

namespace App\Http\Controllers\Api\Drug;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompaniesCollection;
use App\Models\Drug;
use Illuminate\Http\Request;

class DrugCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $drug=Drug::find($id);
        // return $drug->companies;
        $companies= new CompaniesCollection($drug->companies);
        return $this->sendResponse($companies, ['en'=>' Companies List','ar'=>'ثائمة الشركات']);
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        logger($request->all()['newDrugCompanies'][0]['companies_id']);
        // logger(isset($request->products[0]['product_id'])==true?$request->products[0]['product_id']:"nullaa");

        $validator=$this->validate($request,[
            'newDrugCompanies' => 'required',
        ]

    ); //

    $drug=Drug::find($id);
    $drug->companies()->sync($request->all()['newDrugCompanies']);




}

    public function destroy(Request $request,$id)
    {
        logger($request);
        $product=Drug::findOrFail($id);
        $product->companies();
        return $product;   //
    }

}
