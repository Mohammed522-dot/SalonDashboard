<?php

namespace App\Http\Resources\Offers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OffersCollection extends ResourceCollection
{
    public $collects = OffersResources::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
