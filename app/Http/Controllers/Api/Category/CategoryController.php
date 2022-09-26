<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\category\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(request()->has('admin'))
        $categories=Category::with('products')->get();
        else
        $categories=Category::where('active',true)->with('products')->get();


        $categories=new CategoryCollection($categories);
        return $this->sendResponse($categories, __('message.list',['name'=>__('message.category')]));
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


        if($request->icon){
            $name=time().'.'.explode('/',explode(':',substr($request->icon,0,strpos($request->icon,';')))[1])[1];
            Image::make($request->icon)->save(public_path('/icon'.DIRECTORY_SEPARATOR.'Categories/').$name);
            $request->merge(['icon'=>$name]);

            // $oldProfile=public_path('image/profile/').$currentPhoto;
            // if(file_exists($oldProfile))
            // @unlink($oldProfile);
        }


        return Category::create([
            'name'=>$request->name,
            'description'=> $request->description,
            'image'=> $request->icon,
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
        $department= new Category(Category::findOrFail($id));
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




        if($request->icon){
            $name=time().'.'.explode('/',explode(':',substr($request->icon,0,strpos($request->icon,';')))[1])[1];
            Image::make($request->icon)->save(public_path('/icon'.DIRECTORY_SEPARATOR.'Categories/').$name);
            $request->merge(['icon'=>$name]);


            // $oldProfile=public_path('image/profile/').$currentPhoto;
            // if(file_exists($oldProfile))
            // @unlink($oldProfile);
        }


       $category= Category::findOrFail($id);
       $category->fill($request->only([
        'name',
        'description',
        'icon'
    ]));

    // $medicines->name = $request->name;
    // $medicines->description = $request->description;

    if($category->isClean())
    return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],'Sory u should specific diffrent Values',422);

    $category->save();
    return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $category->delete();
        return $category;
    }


    public function changeActive($id){
        $category=Category::findOrFail($id);
        $category->active=!$category->active;
        $category->save();
        return ["activated"=>$category->active];

    }
}
