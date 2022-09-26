<?php

namespace App\Http\Resources\Booking;

use Illuminate\Http\Resources\Json\JsonResource;

class Boking extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'amount' => $this->amount,
            'note'=>$this->note,
            'address' => $this->address,
            'long' => $this->long,
            'lat' => $this->lat,
            'user_id' => $this->user_id,
            'user_name'=>$this->user->name,
            'phone' => $this->user->phone,
            'salon'=>$this->salon,
            'services'=>$this->services,
            'status_id'=>$this->status_id,
        ];
    }
}
