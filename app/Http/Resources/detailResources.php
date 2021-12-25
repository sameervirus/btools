<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class detailResources extends JsonResource
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
            "id" => $this->id,
            "transfer_header_id" => $this->transfer_header_id,
            "item_id" => $this->item_id,
            "item" => new ItemResources($this->item),
            "qty" => $this->qty,
            "cost" => $this->cost,
        ];
    }
}
