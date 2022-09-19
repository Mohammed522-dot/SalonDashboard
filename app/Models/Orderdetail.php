<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    use HasFactory;

    protected $fillable=[
        'amount',
        'drug_id',
        'product_id',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function drugs()
    {
        return $this->belongsTo(Drug::class,'drug_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'');
    }
}
