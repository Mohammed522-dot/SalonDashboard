<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Namescince extends Model
{
    use HasFactory;

    protected $table='nameScinces';

    protected $fillable=[
        'id',
        'name',
        'description',

    ];

    public function drugs(){
        return $this->hasMany(Drug::class,'nameScinces_id');
    }
}
