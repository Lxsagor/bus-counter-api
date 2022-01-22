<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'id'      => $this->id,
            'image'   => $this->image,
            'name'    => $this->name,
            'address' => $this->address,
            'phone'   => $this->phone,
            'details' => $this->details,
            'docs'    => $this->docs,

        ];
    }
}
