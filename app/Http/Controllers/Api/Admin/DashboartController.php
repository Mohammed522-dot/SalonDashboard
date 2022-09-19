<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Department;
use App\Models\Drug;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;

class DashboartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return
        // return auth('api')->user();
        if(auth('api')->user()->role == "admin"){
 
        $orderCount = 0;//Order::where('status_id',Status::DFUALTSTATUS)->count();
        // $drugs_count = Drug::where('active',0)->count();
        $product = Product::where('active',1)->count();
        $company = Company::where('active',1)->count();
        $categories = Category::where('active',1)->count();
        $departments = Department::where('active',1)->count();
        $offers = 0;////Offer::where('active',1)->count();
        $drugs = Drug::where('active',1)->count();

        }else{
            // print_r($fffsd);exit;
            $orderCount = 0;//Order::where('status_id',Status::DFUALTSTATUS)->where('user_id',auth('api')->user()->id)->count();
            // $drugs_count = Drug::where('active',0)->count();

            $product = Product::where('active',1)->count();

            $companyOne = Company::where('active',1)->where('id',auth('api')->user()->salone_id)->first();
            
            
            $categories = Category::where('active',1)->count();
            $departments = Department::where('active',1)->count();
            $offers = 0;//Offer::where('active',1)->count();
            $drugs = $companyOne != null? $companyOne->drugs()->count():0; //Drug::where('active',1)->count();
            // return $companyOne->drugs;

        }

        $data = [
            'orderCount'=>$orderCount,
            'drugs_count'=>$drugs,
            'product'=>$product,
            'company'=>0, // cuz to not get errors in views 
            'categories'=>$categories,
            'departments'=>$departments,
            'offers'=>$offers,
        ];
        return $this->sendResponse($data, ['en'=>' Orders List','ar'=>' ثائمة الطلبات' ]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
