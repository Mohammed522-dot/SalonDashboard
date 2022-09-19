<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmaceuticalform extends Model
{
    use HasFactory;

    protected $table='pharmaceuticalforms';

    protected $fillable=[
        'name',
        'description'
    ];

    public function drugs(){
        return $this->hasMany(Drug::class,'Pharmaceuticalform','id');
    }
}
