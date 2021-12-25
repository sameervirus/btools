<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'code'          => $this->code,
            'name'          => $this->name,
            'unit_id'       => $this->unit_id,
            'unit'          => optional($this->unit)->name,
            'category_id'   => $this->category_id,
            'category'      => optional($this->category)->name,
            'iprice'        => $this->iprice,
            'price'         => $this->price
        ];
    }
}
