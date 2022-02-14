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
            'id'                      => $this->id,
            'starting_district_id'    => $this->starting_district_id,
            'destination_district_id' => $this->destination_district_id,
            'fare'                    => $this->fare,
            'start_point'             => DistrictResource::make($this->whenLoaded('start_point')),
            'destination_point'       => DistrictResource::make($this->whenLoaded('destination_point')),

        ];
    }
}