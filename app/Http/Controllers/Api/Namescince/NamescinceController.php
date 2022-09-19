<?php

namespace App\Http\Controllers\Api\Namescince;

use App\Http\Controllers\Controller;
use App\Models\Namescince;
use Illuminate\Http\Request;

class NamescinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $namescince = Namescince::withCount('drugs')->get();

        return $this->sendResponse($namescince, __('message.list',['name'=>__('message.category')]));


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
        ]);

        return Namescince::create([
            'name'=>$request->name,
            'description'=> $request->description,
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
        $nameScinces= Namescince::findOrFail($id);
        $nameScinces->fill($request->only([
         'name',
         'description'
     ]));

     // $medicines->name = $request->name;
     // $medicines->description = $request->description;

     if($nameScinces->isClean())
     return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],'Sory u should specific diffrent Values',422);

     $nameScinces->save();
     return $nameScinces;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nameScinces = Namescince::findOrFail($id);
        $nameScinces->delete();
        return $nameScinces;
    }
}
