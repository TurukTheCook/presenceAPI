<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IndividualPresenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'apprenant_id' => $this->apprenant_id,
            'presence_id' => $this->presence_id,
            'absent_matin' => $this->absent_matin,
            'absent_aprem' => $this->absent_aprem,
        ];
    }
}
