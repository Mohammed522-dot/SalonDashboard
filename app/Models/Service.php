<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
        'price',
        'time_service',
        'servicetype_id',
        'salons_id'
    ];


    public function salon(){
        return $this->belongsTo(Company::class,'salons_id');//->withPivot('time_service','price');
    }

    public function bookings(){
        return $this->belongsToMany(Booking::class,'bookings_services','service_id','booking_id');
    }    
}
