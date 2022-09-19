<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'price',
        'count',
        'image',
    ];
    public function departments(){
        return $this->belongsToMany(Department::class,'departments_products','products_id','departments_id');
    }

    public function offers(){
        return $this->hasMany(Offer::class,'drug_id','id');
    }
}
