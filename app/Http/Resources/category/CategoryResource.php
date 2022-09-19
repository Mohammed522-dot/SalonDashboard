<?php

namespace App\Http\Resources\category;

use App\Http\Resources\DepartmentsCollection;
use App\Http\Resources\DepartmentsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'icon'=> $this->image,
            'active'=>$this->active,
            'description' => $this->description,
            'departments'=> $this->departments, // DepartmentsResource::collection($this->departments),
        ];
    }
}
