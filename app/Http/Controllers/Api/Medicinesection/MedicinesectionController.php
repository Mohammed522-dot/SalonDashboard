<?php

namespace App\Http\Controllers\Api\Medicinesection;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicinesectionResource;
use App\Models\Medicinesection;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
class MedicinesectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('admin'))
        $mdSection=Medicinesection::withCount('drugs')->get();
        else
        $mdSection=Medicinesection::where('active',true)->withCount('drugs')->get();

        $medicinesSection= $mdSection;
        return $this->sendResponse($medicinesSection, ['en'=>' Medicinesection List','ar'=>' ثائمة الاقسام الادوية' ]);
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
            'name'=> 'required|string|max:191',
            'description'=>'required|string|min:20',
            'icon'=>'required|string|min:6',
        ]);


        if($request->icon){
            $name=time().'.'.explode('/',explode(':',substr($request->icon,0,strpos($request->icon,';')))[1])[1];
            Image::make($request->icon)->save(public_path('/icon'.DIRECTORY_SEPARATOR.'Medicinesections/').$name);
            $request->merge(['icon'=>$name]);

            // $oldProfile=public_path('image/profile/').$currentPhoto;
            // if(file_exists($oldProfile))
            // @unlink($oldProfile);
        }


        return Medicinesection::create([
            'name'=>$request->name,
            'description'=> $request->description,
            'icon'=> $request->icon,
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $medicines= new MedicinesectionResource(Medicinesection::findOrFail($id));
        return $this->sendResponse($medicines, ['en'=>' Departments List','ar'=>'ثائمة الاقسام']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $medicines=  Medicinesection::findOrFail($id);
        $medicines->fill($request->only([
            'name',
            'description'
        ]));

        // $medicines->name = $request->name;
        // $medicines->description = $request->description;

        if($medicines->isClean())
        return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],'Sory u should specific diffrent Values',422);

        $medicines->save();
        return $medicines;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medicines=Medicinesection::find($id);
        $medicines->delete();
        return $medicines;
    }


    public function changeActive($id){
        $medicines=Medicinesection::findOrFail($id);
        $medicines->active=!$medicines->active;
        $medicines->save();
    return ["activated"=>$medicines->active];

    }
}
