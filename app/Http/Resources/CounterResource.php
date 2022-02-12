<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CounterResource extends JsonResource
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
            'division_id'      => $this->division_id,
            'district_id'      => $this->district_id,
            'name'             => $this->name,
            'district'         => DistrictResource::make($this->whenLoaded('district')),
            'division'         => DivisionResource::make($this->whenLoaded('division')),
            'counter_managers' => UserResource::collection($this->whenLoaded('counter_managers')),
        ];
    }
}