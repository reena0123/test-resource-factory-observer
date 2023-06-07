<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
        'id' => $this->id,
        'full_name' => $this->first_name." ".$this->last_name,
        'email' => $this->email,
        'phone' => $this->phone,
        'address' => $this->city.", ".$this->state.", ".$this->country,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at
        ];
    }
}
