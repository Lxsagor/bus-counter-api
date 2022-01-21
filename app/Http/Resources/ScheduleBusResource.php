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
            'bus_no'        => $this->bus_no,
            'start_counter' => $this->start_counter,
            'end_counter'   => $this->end_counter,
            'mid_counters'  => $this->mid_counters,
            'date'          => $this->date,
            'time'          => $this->time,

        ];
    }
}
