<?php

use App\Http\Controllers\Api\Admin\BookingController;
use App\Http\Controllers\Api\Admin\DashboartController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\OrderOrderDetailsController;
use App\Http\Controllers\Api\Admin\Salon\SalonServicesController;
use App\Http\Controllers\Api\Admin\Services\ServicesController;
use App\Http\Controllers\Api\Admin\ServiceType\ServicesTypeController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Category\CategoryDepartmentController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\Company\CompanyDrugsController;
use App\Http\Controllers\Api\Department\DepartmentController;
use App\Http\Controllers\Api\Department\DepartmentProducts;
use App\Http\Controllers\Api\Drug\DrugCompanyController;
use App\Http\Controllers\Api\Drug\DrugController;
use App\Http\Controllers\Api\Drug\DrugInstanceController;
use App\Http\Controllers\Api\Drug\DrugOperationController;
use App\Http\Controllers\Api\File\FileController;
use App\Http\Controllers\Api\Medicinesection\MedicinesectionController;
use App\Http\Controllers\Api\Medicinesection\MedicinesectionDrugsController;
use App\Http\Controllers\Api\MyFirebase\MyFirebaseController;
use App\Http\Controllers\Api\Namescince\NamescinceController;
use App\Http\Controllers\Api\Offers\OfferController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Order\OrderOfferController;
use App\Http\Controllers\Api\Pharmaceuticalforms\PharmaceuticalformsController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Product\ProductSubCategoryController;
use App\Http\Controllers\Api\User\MyAuthController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\UserCompaniesController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [MyAuthController::class, 'register']);
Route::post('login', [MyAuthController::class, 'login']);
Route::post('verify', [MyAuthController::class, 'verify']);
Route::post('resend',[MyAuthController::class,'resend']);


Route::apiResource('companies',CompanyController::class);
Route::apiResource('companies.drugs',CompanyDrugsController::class,['only'=>['index']]);



Route::apiResource('categories',CategoryController::class,['only'=>['index','show']]);
Route::apiResource('categories.departments',CategoryController::class,['only'=>['index']]);

Route::apiResource('departments',DepartmentController::class);
Route::apiResource('departments.products',DepartmentProducts::class,['only'=>['index']]);

Route::apiResource('medicinesection',MedicinesectionController::class);
Route::apiResource('medicinesection.drugs',MedicinesectionDrugsController::class,['only'=>['index']]);

Route::apiResource('offers',OfferController::class,['only'=>['index','show']]);



Route::apiResource('drugs',DrugController::class,['only'=>['index','show']]);
Route::apiResource('drugs.instances',DrugInstanceController::class,['only'=>['index']]);
Route::apiResource('drugs.companies',DrugCompanyController::class,['only'=>['index']]);


Route::apiResource('orders',OrderController::class)->middleware('auth:api');//['only'=>['index','show']]

Route::apiResource('bookings',OrderOfferController::class)->middleware('auth:api');//['only'=>['index','show']]

Route::get('famusInstance',[DrugController::class,'famusInstance']);//->middleware('auth:api');//['only'=>['index','show']]


Route::apiResource('orders_uploads',FileController::class)->middleware('auth:api');//['only'=>['index','show']]


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('download')->group(function () {

Route::get('/categories/{id}',[FileController::class,'downloadImage']);

});

// Route::apiResource('profile',ProfileController::class);

//

Route::prefix('admin')->group(function () {
    Route::apiResource('/users',UserController::class);//->middleware('auth');
    Route::apiResource('/users.companies',UserCompaniesController::class);//->middleware('auth');
    Route::apiResource('/medicinesections',MedicinesectionController::class);
    Route::apiResource('/medicinesections.drugs',MedicinesectionDrugsController::class);
    Route::apiResource('/categories',CategoryController::class);
    Route::apiResource('/categories.departments',CategoryDepartmentController::class);
    Route::apiResource('/departments',DepartmentController::class);
    Route::apiResource('/departments.products',DepartmentProducts::class);
    Route::apiResource('/companies',CompanyController::class);
    Route::apiResource('/offers',OfferController::class);
    
    //TODO Old  Route Drugs Must Be Deleted After Check New succseed
    Route::apiResource('/drugs',DrugController::class);
    Route::apiResource('/services',ServicesController::class);
    ///////////////////////

    Route::apiResource('/salons/{id}/services',SalonServicesController::class);
    Route::apiResource('/servicesTypes',ServicesTypeController::class);

    
    Route::apiResource('/products',ProductController::class);
    Route::apiResource('/products.subcategories',ProductSubCategoryController::class);
    Route::apiResource('/drugs.companies',DrugCompanyController::class,['only'=>['index','store','destroy']]);
    Route::apiResource('/reports',AdminOrderController::class);//['only'=>['index','show']]

    Route::apiResource('/orders.details',OrderOrderDetailsController::class);//['only'=>['index','show']]

    Route::apiResource('/orders',BookingController::class);//['only'=>['index','show']s]

    Route::apiResource('/bookings',BookingController::class);//['only'=>['index','show']]

    Route::get('/dashboard',[DashboartController::class,'index']);//['only'=>['index','show']]

    Route::apiResource('/pharmaceuticalforms',PharmaceuticalformsController::class);//['only'=>['index','show']]
    Route::apiResource('/nameScinces',NamescinceController::class);//['only'=>['index','show']]

    Route::get('/drugs/{id}/operation',[DrugOperationController::class,'changeActive']);
    Route::get('/companies/{id}/operation',[CompanyController::class,'changeActive']);
    Route::get('/categories/{id}/operation',[CategoryController::class,'changeActive']);
    Route::get('/departments/{id}/operation',[DepartmentController::class,'changeActive']);
    Route::get('/products/{id}/operation',[ProductController::class,'changeActive']);
    Route::get('/offers/{id}/operation',[OfferController::class,'changeActive']);
    Route::get('/medicinesections/{id}/operation',[MedicinesectionController::class,'changeActive']);

    Route::apiResource('/profile',ProfileController::class)->middleware('auth:api');

});


Route::apiResource('profile',ProfileController::class)->middleware('addAccessToken');



Route::get('sms',[MyAuthController::class,'testSms']);


Route::get('fire',[MyFirebaseController::class,'index']);
