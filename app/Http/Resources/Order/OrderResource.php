<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Prescriptions\PrescriptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' => $this->id,
            'note' => $this->note,
            'address' => $this->address,
            'long' => $this->long,
            'lat' => $this->lat,
            'prescriptions' => PrescriptionResource::collection($this->prescriptions),
            'orderdetails'=>$this->orderdetails,
            'username'=>$this->user->name,
            'products'=>$this->products,
            'drugs'=>$this->drugs,
            'drugs_count'=>$this->drugs->count(),
            'status_id'=>$this->status_id,
            'products_count'=>$this->products->count(),
            'prescriptions_count'=>$this->prescriptions->count()
        ];
    }
}
