<?php

namespace App\Http\Resources;

use App\Http\Resources\CounterManager\AssignBusResource;
use App\Models\District;
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
            'id'            => $this->id,
            'bus_type'      => $this->bus_type,
            'bus_seat_type' => $this->bus_seat_type,
            // 'start_counter_id' => $this->start_counter_id,
            // 'end_counter_id'   => $this->end_counter_id,
            'routes_id'     => $this->routes_id,
            'day_time'      => $this->day_time,
            'fares'         => $this->fares,
            // 'bus'           => BusResource::make($this->whenLoaded('bus_by_no')),
            // 'start_counter' => CounterResource::make($this->whenLoaded('start_counter')),
            // 'end_counter'   => CounterResource::make($this->whenLoaded('end_counter')),
            'assignBuses'   => AssignBusResource::collection($this->whenLoaded('assign_buses')),
        ];

        if ($this->routes_id && count($this->routes_id) > 0) {
            $midCounters = [];
            foreach ($this->routes_id as $item) {
                $district = District::where('_id', $item)->first();

                if ($district) {
                    array_push($midCounters, DistrictResource::make($district));
                }
            }

            $data['routes'] = $midCounters;
        }

        return $data;
    }
}