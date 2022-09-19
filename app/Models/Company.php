<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'salons';
    protected $fillable=[
        'name',
        'description',
        'logo',
        'active',
    ];

    public function drugs(){

        // return "ana";
        return $this->belongsToMany(Drug::class,'companies_drugs','companies_id','drugs_id');
    }

    public function services(){
        // return "ana";
        return $this->hasMany(Service::class,'salons_id');
    }

    public function servicesTypes(){
        // return "ana";
        return $this->belongsToMany(Service::class,'services','salons_id','service_id')->withPivot('time_service','price');;
    }    
    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    
}
