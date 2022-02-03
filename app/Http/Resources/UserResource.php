<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'role_id' => $this->role_id,
            'status'  => $this->status,
            // 'added_on' => Carbon::parse($this->created_at)->format('d/m/Y h:m:i'),
            // 'added_on' => $this->added_on,

        ];
    }
}