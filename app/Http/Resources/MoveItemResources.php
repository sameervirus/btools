<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MoveItemResources extends JsonResource
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
            'id' => $this->id,
            'trans_no' => $this->trans_no,
            'trans_date' => $this->trans_date,
            'qty' => $this->qty,
            'cost' => $this->cost,
            'comments' => $this->comments,
            'invo_no' => $this->invo_no,
            'invo_date' => $this->invo_date,
            'from' => $this->from,
            'from_warehouse' => optional($this->from_warehouse)->name,
            'to' => $this->to,
            'to_warehouse' => optional($this->to_warehouse)->name,
            'transfer_type_id' => $this->transfer_type_id,
            'transfer_type_name' => optional($this->transfer)->name,
            'user_id' => $this->user_id,
            'user' => optional($this->user)->name,
            'client_id' => $this->client_id,
            'client' => optional($this->client)->name,
            'details' => detailResources::collection($this->details)
        ];
    }
}
