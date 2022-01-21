<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusResource extends JsonResource
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
            'bus_no'     => $this->bus_no,
            'bus_reg_no' => $this->bus_reg_no,
            'chesis_no'  => $this->chesis_no,
            'bus_type'   => $this->bus_type,
            'total_seat' => $this->total_seat,
        ];
    }
}
