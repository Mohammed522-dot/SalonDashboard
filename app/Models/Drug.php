<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;
    protected $table = "services";
    protected $fillable=[
        'drugs_name',
        'status',
        'Pharmaceuticalform',
        'description',
        'price',
        'count',
        'Reasonuse',
        'sideeffects',
        'Dosing',
        'activesubstance',
        'Interactions',
        'icons',
        'medicinesection_id',
        'famusInstance',
        'active'
    ];

    public function companies(){
        return $this->belongsToMany(Company::class,'companies_drugs','drugs_id','companies_id')->withPivot('amount','price');
    }

    public function medicinesection(){
        return $this->belongsTo(Medicinesection::class);
    }

    public function offers(){
        return $this->hasMany(Offer::class,'drug_id','id');
    }

    public function pharmaceuticalform(){
        return $this->belongsTo(Pharmaceuticalform::class,'Pharmaceuticalform','id');
    }

    public function nameScince(){
        return $this->belongsTo(Namescince::class,'nameScinces_id');
    }
}
