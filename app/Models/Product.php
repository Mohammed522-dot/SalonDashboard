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
    public function category(){
        return $this->belongsToMany(Category::class,' categories_id ');
    }
    

    public function offers(){
        return $this->hasMany(Offer::class,'drug_id','id');
    }
}
