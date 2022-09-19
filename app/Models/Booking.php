<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table='bookings';

    protected $fillable=[
            'note',
            'address',
            'long',
            'lat',
            'user_id',
            'salon_id',
            'status_id',
            'amount'
    ];

    public function salon(){
        return $this->belongsTo(Company::class,'salon_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function services(){
        return $this->belongsToMany(Service::class,'bookings_services','booking_id','service_id');
    }


    public function status(){
        return $this->belongsTo(Status::class,'status_id');
    }
}
