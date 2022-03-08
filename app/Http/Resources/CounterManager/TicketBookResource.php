<?php

namespace App\Http\Resources\CounterManager;

use App\Http\Resources\ScheduleBusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketBookResource extends JsonResource
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
            'id'             => $this->id,
            'seat_no'        => $this->seat_no,
            'fare  '         => $this->fare,
            'name  '         => $this->name,
            'phone  '        => $this->phone,
            'coach_id  '     => $this->coach_id,
            'route_id  '     => $this->route_id,
            'journey_time  ' => $this->journey_time,

            'coach'          => AssignBusResource::make($this->whenLoaded('assign_bus')),
            'route'          => ScheduleBusResource::make($this->whenLoaded('schedule_bus')),
        ];
    }
}