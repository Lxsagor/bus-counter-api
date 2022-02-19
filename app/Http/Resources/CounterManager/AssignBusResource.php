<?php

namespace App\Http\Resources\CounterManager;

use App\Http\Resources\BusResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DriverResource;
use App\Http\Resources\StaffResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignBusResource extends JsonResource
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
            'bus_no'           => $this->bus_no,
            'bus_type'         => $this->bus_type,
            'driver_id'        => $this->driver_id,
            'staff_id'         => $this->staff_id,
            'supervisor'       => $this->supervisor,
            'journey_start_id' => $this->journey_start_id,
            'journey_end_id'   => $this->journey_end_id,
            'date_time'        => $this->date_time,

            'bus'              => BusResource::make($this->whenLoaded('bus_by_no')),
            'journey_start'    => DistrictResource::make($this->whenLoaded('journey_start')),
            'journey_end'      => DistrictResource::make($this->whenLoaded('journey_end')),
            'driver'           => DriverResource::make($this->whenLoaded('driver')),
            'staff'            => StaffResource::make($this->whenLoaded('staff')),

        ];
    }
}