<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
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
            "id"                => $this->id,
            "image"             => $this->image,
            "contact_number"    => $this->contact_number,
            "dob"               => $this->dob,
            "country"           => $this->country,
            "state"             => $this->state,
            "zip_code"          => $this->zip_code,
            "address_1"         => $this->address_1,
            "address_2"         => $this->address_2,
            "speciality"        => $this->speciality,
            "experience"        => $this->experience,
            "web_link"          => $this->web_link
        ];
    }
}
