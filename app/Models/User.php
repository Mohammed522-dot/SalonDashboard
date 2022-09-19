<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
     
        'role',
        'token_firebase',
        'otp_code',
        'salone_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Set as username any column from users table
    public function findForPassport($username)
    {
        $customUsername = 'phone';
        return $this->where($customUsername, $username)->first();
    }

                            
    // public function companies()
    // {
    //     return $this->hasOne(Company::class,"user_id","id");
    // }
    
    public function orders()
    {
        return $this->hasMany(Order::class,"user_id","id");
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class,"user_id","id");
    }    
}
