<?php

namespace App\Http\Resources;

use App\Models\District;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
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
            'id'       => $this->id,
            'route'    => $this->route,
            'bus_type' => $this->bus_type,
            'day_time' => $this->day_time,
        ];
        if ($this->route && count($this->route) > 0) {
            $routes = [];
            foreach ($this->route as $item) {
                $district = District::where('_id', $item)->first();

                if ($district) {
                    array_push($routes, DistrictResource::make($district));
                }
            }

            $data['districts'] = $routes;
        }

        return $data;

    }
}