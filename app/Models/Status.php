<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    const DFUALTSTATUS='1';

    protected $table='status';

    protected $fillable=[
        'id',
        'name',
    ];

    static function defaultStatus($tableName){
            return static::where('table',static::DFUALTSTATUS)->first();
    }

    public function bookings(){
        return $this->hasMany(Booking::class,'status_id');
    }

    public function drugs(){
        return $this->hasMany(Drug::class,'status_id');
    }

}
