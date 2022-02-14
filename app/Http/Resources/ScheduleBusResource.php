<?php

namespace App\Http\Resources;

use App\Models\Counter;
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
        $data = [
            'id'               => $this->id,
            'bus_id'           => $this->bus_id,
            'bus_no'           => $this->bus_no,
            'start_counter_id' => $this->start_counter_id,
            'end_counter_id'   => $this->end_counter_id,
            'mid_counters_id'  => $this->mid_counters_id,
            'date_time'        => $this->date_time,

            'bus'              => BusResource::make($this->whenLoaded('bus_by_no')),
            'start_counter'    => CounterResource::make($this->whenLoaded('start_counter')),
            'end_counter'      => CounterResource::make($this->whenLoaded('end_counter')),
        ];

        if ($this->mid_counters_id && count($this->mid_counters_id) > 0) {
            $midCounters = [];
            foreach ($this->mid_counters_id as $item) {
                $counter = Counter::where('_id', $item)->first();

                if ($counter) {
                    array_push($midCounters, CounterResource::make($counter));
                }
            }

            $data['mid_counters'] = $midCounters;
        }

        return $data;
    }
}