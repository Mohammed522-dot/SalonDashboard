<?php

namespace App\Http\Controllers\Api\Pharmaceuticalforms;

use App\Http\Controllers\Controller;
use App\Models\Pharmaceuticalform;
use Illuminate\Http\Request;

class PharmaceuticalformsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pharmaceuticalforms = Pharmaceuticalform::withCount('drugs')->get();
        return $this->sendResponse($pharmaceuticalforms,[]);
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

        return Pharmaceuticalform::create([
            'name'=>$request->name,
            'description'=> $request->description,
            'image'=> $request->icon,
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
        $pharmaceuticalforms = Pharmaceuticalform::findOrFail($id);
        return $this->sendResponse($pharmaceuticalforms, []);
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
        $pharmaceuticalforms= Pharmaceuticalform::findOrFail($id);
        $pharmaceuticalforms->fill($request->only([
         'name',
         'description'
     ]));

     // $medicines->name = $request->name;
     // $medicines->description = $request->description;

     if($pharmaceuticalforms->isClean())
     return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],'Sory u should specific diffrent Values',422);

     $pharmaceuticalforms->save();
     return $pharmaceuticalforms;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pharmaceuticalforms = Pharmaceuticalform::findOrFail($id);
        $pharmaceuticalforms->delete();
        return $pharmaceuticalforms;
    }
}
