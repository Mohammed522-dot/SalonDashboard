<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'category_id',
        'icon',
        'active'
    ];
    function products(){
        return $this->belongsToMany(Product::class,'departments_products','departments_id','products_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

}
