<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FareResource extends JsonResource
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
            'id'                    => $this->id,
            'schedule_bus_id'       => $this->schedule_bus_id,
            'starting_counter_id'   => $this->starting_counter_id,
            'destination_counte_id' => $this->destination_counte_id,
            'fare'                  => $this->fare,

        ];
    }
}