<?php

namespace App\Http\Resources;

use App\Models\Drug;
use Illuminate\Http\Resources\Json\JsonResource;

class DrugsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {//
        // return parent::toArray($request);
        return [
            "id" =>$this->id,
            "drugs_name" => $this->drugs_name,
            "status" => $this->status,
            "Pharmaceuticalform" => $this->Pharmaceuticalform,
            "description" => $this->description,
            "price"  => $this->companies->firstWhere('pivot.amount','>=',1)->pivot->price,
            "count" => $this->companies->firstWhere('pivot.amount','>=',1)->pivot->amount,
            "Reasonuse" => $this->Reasonuse,
            "sideeffects" => $this->sideeffects,
            "Dosing"  => $this->Dosing,
            "activesubstance" => $this->activesubstance,
            "Interactions"  => $this->Interactions,
            "icons"  => $this->icons,
            "InstancesUrl"=>url("api/drugs/{$this->id}/instances"),
            "InstanceCount" => Drug::where('nameScinces_id',$this->nameScinces_id)->where('id','!=',$this->id)->where('medicinesection_id',$this->medicinesection_id)->count(),
            "medicinesection_id"=> $this->medicinesection_id,
            "medicinesection_name"=>$this->medicinesection->name,
            "company_name"=>$this->companies->firstWhere('pivot.amount','>=',1)->name,
            "nameScinces_id"=>$this->nameScinces_id,
            "active" => $this->active
        ];
    }
}
