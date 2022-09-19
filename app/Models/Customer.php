<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    protected $table= "customers";
    protected $fillable = [
            'id',
            'name',
            'email',
            'email_verified_at',
            'password',
            'phone',
            'phone_verified_at',
            'otp_code',
            'remember_token',
            'role',
            'address',
            'age',
            'token_firebase',
            'created_at',
            'updated_at',        
    ];
}
