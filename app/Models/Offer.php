<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable=[
        'name',
        'price',
        'description',
        'strDate',
        'endDate',
        'price',
        'product_id',
        'drug_id'
    ];
    use HasFactory;


    public function drug(){

        return $this->belongsTo(Drug::class,'drug_id','id');
    }

    public function product(){

        return $this->belongsTo(Product::class,'product_id','id');
    }

    // public function orders(){
    //     return $this->belongsToMany(Order::class,'orders_offers','offer_id','order_id')->withPivot('amount');
    // }

    public function bookings(){
        return $this->hasMany(Booking::class,'offer_id');
    }


}
