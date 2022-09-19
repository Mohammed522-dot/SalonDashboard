<?php

namespace App\Http\Controllers\Api\Drug;

use App\Http\Controllers\Controller;
use App\Http\Resources\DrugsCollection;
use App\Http\Resources\DrugsResource;
use App\Models\Drug;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(auth('api')->user()->role == "admin"){         
        //     $drugs=Drug::collection(Drug::orderByDesc('created_at')->get());
        //     return $this->sendResponse($drugs, ['en'=>' Orders List','ar'=>'ثائمة الادوية' ]);
        //     }else{
        //         $drugs=Drug::collection(Drug::where('user_id',auth('api')->user()->id)->orderByDesc('created_at')->get());
        //         return $this->sendResponse($drugs, ['en'=>' Orders List','ar'=>' ثائمة الادوية' ]);    
        //     }


        dd(Drug::all());
        if(request()->has('admin'))
        $drugs=new DrugsCollection(Drug::all());
        else
        $drugs=new DrugsCollection(Drug::where('active',true)->get());

        return $this->sendResponse($drugs, ['en'=>' Drugs List','ar'=>' ثائمة الادوية' ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'drugs_name'=> 'required|string|max:50',
            'Pharmaceuticalform'=>'required',
            'description'=>'required|string|min:20',
            // 'price'=>'required|integer|min:20',
            // 'count'=>'required|integer|min:20',
            'Reasonuse'=>'required|string|min:3',
            'sideeffects'=>'required|string|min:3',
            'Dosing'=>'required|string|min:3',
            'activesubstance'=>'required|string|min:3',
            'Interactions'=>'required|string|min:3',
            'medicinesection_id'=>'required',
            'newDrugCompanies.*.companies_id'=>'required',
            'newDrugCompanies.*.price'=>'required',
            'newDrugCompanies.*.amount'=>'required',
            'nameScinces_id'=>'required',
            'newDrugCompanies' => 'required'

        ]);



        if($request->icons){
            $name=time().'.'.explode('/',explode(':',substr($request->icons,0,strpos($request->icons,';')))[1])[1];
            Image::make($request->icons)->save(public_path('/icon'.DIRECTORY_SEPARATOR.'Drugs/').$name);
            $request->merge(['icons'=>$name]);

            // $oldProfile=public_path('image/profile/').$currentPhoto;
            // if(file_exists($oldProfile))
            // @unlink($oldProfile);
        }


        $drug= Drug::create([
            'drugs_name' => $request->drugs_name,
            'status' => true,
            'Pharmaceuticalform' => $request->Pharmaceuticalform,
            'description' => $request->description,
            'Reasonuse' => $request->Reasonuse,
            'sideeffects' => $request->sideeffects,
            'Dosing' => $request->Dosing,
            'activesubstance' => $request->activesubstance,
            'Interactions' => $request->Interactions,
            'icons' => $request->icons,
            'medicinesection_id'=>$request->medicinesection_id,
            'nameScinces_id' => $request->nameScinces_id
        ]);

        $drug->companies()->attach($request->all()['newDrugCompanies']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $drugDetails= new DrugsResource(Drug::findOrFail($id));
        return $this->sendResponse($drugDetails, ['en'=>' Drugs List','ar'=>'ثائمة الادوية']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        logger($request->all());
        $drug= Drug::findOrFail($id);

        $drug->drugs_name = $request->drugs_name;
        $drug->status = true;
        $drug->Pharmaceuticalform = $request->Pharmaceuticalform;
        $drug->description = $request->description;
        $drug->Reasonuse = $request->Reasonuse;
        $drug->sideeffects = $request->sideeffects;
        $drug->Dosing = $request->Dosing;
        $drug->activesubstance = $request->activesubstance;
        $drug->Interactions = $request->Interactions;
        $drug->medicinesection_id= $request->medicinesection_id;
        $drug->nameScinces_id = $request->nameScinces_id;




    // $medicines->name = $request->name;
    // $medicines->description = $request->description;

    // if($drug->isClean())
    // return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],'Sory u should specific diffrent Values',422);

    $drug->save();
    return $drug;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drug=Drug::findOrFail($id);
        $drug->companies()->detach();

        $drug->delete();

        return $drug;
    }


    public function famusInstance(){
        $drugDetails= DrugsResource::collection(Drug::where('famusInstance',true)->get());
        return $this->sendResponse($drugDetails, ['en'=>' Drugs List','ar'=>'ثائمة الادوية']);

    }
}
