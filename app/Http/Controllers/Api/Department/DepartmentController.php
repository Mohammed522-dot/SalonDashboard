<?php

namespace App\Http\Controllers\Api\Department;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentsCollection;
use App\Http\Resources\DepartmentsResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('admin'))
        $depts=Department::all();
        else
        $depts=Department::where('active',true)->get();
        $departments=new DepartmentsCollection($depts);
        return $this->sendResponse($departments, ['en'=>' Departments List','ar'=>'ثائمة  الاقسام الفرعية ']);
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
            // 'icon'=>'required|string|min:6',
        ]);

        return Department::create([
            'name'=>$request->name,
            'description'=> $request->description,
            'icon'=>'ana.jpg',
            'category_id'=>$request->category_id,
            'active'=> false,
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
        $department= new DepartmentsResource(Department::findOrFail($id));
        return $this->sendResponse($department, ['en'=>' Departments List','ar'=>'ثائمة الاقسام']);

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
        $department= Department::findOrFail($id);
        $department->fill($request->only([
         'name',
         'description',
         'category_id'
     ]));

     // $medicines->name = $request->name;
     // $medicines->description = $request->description;

     if($department->isClean())
     return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],'Sory u should specific diffrent Values',422);

     $department->save();
     return $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department=Department::findOrFail($id);
        $department->delete();
        return $department;
    }



    public function changeActive($id){
        $department=Department::findOrFail($id);
        $department->active=!$department->active;
        $department->save();
        return ["activated"=>$department->active];

    }
}
