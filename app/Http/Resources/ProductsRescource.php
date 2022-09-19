<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsRescource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" =>$this->id,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "count" => $this->count,
            "image"  => $this->image,
            // "count" => $this->companies->firstWhere('pivot.amount','>=',1)->pivot->amount,
            // "medicinesection_name"=>$this->medicinesection->name,
            // "company_name"=>$this->companies->firstWhere('pivot.amount','>=',1)->name,
            "active" => $this->active
        ];

    }
}
