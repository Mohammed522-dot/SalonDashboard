<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;
    protected $table = 'servicestypes';
    protected $fillable = [
        'id',
        'name',
        'description',
        'image'
    ];

    public function companies(){
        return $this->belongsToMany(Company::class,'services','service_id','salons_id')->withPivot('time_service','price');
    }
}
