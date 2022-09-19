<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // TODO this number is Status Order Cancel and saved in Table Status foreginKey

    const ORDERCANCEL=2;

    protected $fillable=[
        'note',
        'address',
        'long',
        'lat',
        'user_id',
        'customer_id',
    ];
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function orderdetails()
    {
        return $this->hasMany(Orderdetail::class,"order_id","id");
    }


    public function drugs(){
        return $this->belongsToMany(Drug::class,'order_drug','order_id','drug_id')->withPivot('amount');;
    }


    public function products(){
        return $this->belongsToMany(Product::class,'orderdetails','order_id','product_id')->withPivot('amount');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offers(){
        return $this->belongsToMany(Offer::class,'orders_offers','order_id','offer_id')->withPivot('amount');
    }


}
