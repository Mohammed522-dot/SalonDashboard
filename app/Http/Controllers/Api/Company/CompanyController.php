<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompaniesCollection;
use App\Http\Resources\DepartmentsCollection;
use App\Models\Company;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('admin'))
        $companies = Company::all();
        else
        $companies=Company::where('active',true)->get();
        $companies=new CompaniesCollection($companies);
        return $this->sendResponse($companies, ['en'=>' Companies List','ar'=>'ثائمة الشركات']);
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
        'logo'=>'required|string|min:6',
    ]);


    if($request->logo){
        $name=time().'.'.explode('/',explode(':',substr($request->logo,0,strpos($request->logo,';')))[1])[1];
        Image::make($request->logo)->save(public_path('/icon'.DIRECTORY_SEPARATOR.'companies/').$name);
        $request->merge(['logo'=>$name]);

        // $oldProfile=public_path('image/profile/').$currentPhoto;
        // if(file_exists($oldProfile))
        // @unlink($oldProfile);
    }


    return Company::create([
        'name'=>$request->name,
        'description'=> $request->description,
        'logo'=> $request->logo,
        'active'=>false
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
        //
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
        $medicines=  Company::findOrFail($id);
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
        $services=Company::find($id);
        $services->services();
        $services->delete();
        return $services;
    }

    public function changeActive($id){
        $company=Company::findOrFail($id);
        $company->active=!$company->active;
        $company->save();
        return ["activated"=>$company->active];
    }
}
