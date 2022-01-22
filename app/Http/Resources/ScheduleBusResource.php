<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleBusResource extends JsonResource
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
            'id'               => $this->id,
            'bus_id'           => $this->bus_id,
            'bus_no'           => $this->bus_no,
            'start_counter_id' => $this->start_counter_id,
            'end_counter_id'   => $this->end_counter_id,
            'mid_counters_id'  => $this->mid_counters_id,
            'date_time'        => $this->date_time,

        ];
    }
}
