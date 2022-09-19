<?php

namespace App\Http\Resources\Offers;

use App\Http\Resources\DrugsResource;
use App\Http\Resources\ProductsRescource;
use Illuminate\Http\Resources\Json\JsonResource;

class OffersResources extends JsonResource
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
            "strDate" => $this->strDate,
            "endDate" => $this->endDate,
            "price"  => $this->price,
            "product_id" => $this->product_id,
            "drug_id" => $this->drug_id,
            "drug"=> new DrugsResource($this->drug),
            "product"=> new ProductsRescource($this->product),
            "active"=> $this->active
        ];
    }
}
