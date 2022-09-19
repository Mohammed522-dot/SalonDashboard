<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsCollection;
use App\Http\Resources\ProductsRescource;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('admin'))
        $products=Product::with('departments')->get();
        else
        $products=Product::where('active',true)->with('departments')->get();

        return $this->sendResponse($products, ['en'=>' Products List','ar'=>' ثائمة لمنتجات' ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->image){
            $name=time().'.'.explode('/',explode(':',substr($request->image,0,strpos($request->image,';')))[1])[1];
            Image::make($request->image)->save(public_path('/icon'.DIRECTORY_SEPARATOR.'Products/').$name);
            $request->merge(['icon'=>$name]);

            // $oldProfile=public_path('image/profile/').$currentPhoto;
            // if(file_exists($oldProfile))
            // @unlink($oldProfile);
        }

        $product=Product::create([
            'name'=>$request->name,
            'description'=> $request->description,
            'price'=>$request->price,
            'count'=>$request->count,
            'image'=> $request->icon,
        ]);


        $product->departments()->sync(
            $request->subCategorie_id
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products=new ProductsRescource(Product::findOrFail($id));
        return $this->sendResponse($products, ['en'=>' Products List','ar'=>' ثائمة لمنتجات' ]);
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
        $product= Product::findOrFail($id);
        $product->fill($request->only([
         'name',
         'description',
         'price',
         'count'
     ]));

     // $medicines->name = $request->name;
     // $medicines->description = $request->description;

    //  if($product->isClean())
    //  return $this->sendError(['en'=>"validation Erros",'ar'=>'خطا في البيانات المرسلة'],'Sory u should specific diffrent Values',422);

     $product->save();


     $product->departments()->sync(
        $request->subCategorie_id
    );


     return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $product->delete();
        return $product;   //
    }

    public function changeActive($id){
        $product=Product::findOrFail($id);
        $product->active=!$product->active;
        $product->save();

        return ["activated"=>$product->active];

    }
}
