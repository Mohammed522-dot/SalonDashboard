<?php

use App\Http\Controllers\Home\HomeController;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require __DIR__.'/auth.php';


Route::get('/test', function () {
    return view('test');
});


Route::get('/', function () {
    $booking_count=Booking::where('status_id',0)->count();
    $order_count=0;//Order::where('status_id',0)->count();
    $data=['orders_count'=>$order_count,'booking_count'=>$booking_count];

    return view('welcome',['data'=>$data]);
});

Route::get('/dashboard', [HomeController::class,'index'])->middleware(['auth'])->name('dashboard');


Route::get('{path}', function () {
    $booking_count=Booking::where('status_id',0)->count();
    $order_count=0;//Order::where('status_id',0)->count();
    $data=['orders_count'=>$order_count,'booking_count'=>$booking_count];

    return view('home',['data'=>$data]);
})->middleware(['auth'])->name('dashboard');

