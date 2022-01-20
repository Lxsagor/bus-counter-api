<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'id'                        => $this->id,
            'name'                      => $this->name,
            'email'                     => $this->email,
            'phone'                     => $this->phone,
            'no_of_counters'            => $this->no_of_counters,
            'sub_start_date'            => $this->sub_start_date,
            'sub_end_date'              => $this->sub_end_date,
            'sub_start_date_bangladesh' => $this->sub_start_date_bangladesh,
            'sub_end_date_bangladesh'   => $this->sub_end_date_bangladesh,

        ];
    }
}
