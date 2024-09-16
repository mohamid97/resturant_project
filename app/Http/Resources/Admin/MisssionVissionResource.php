<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MisssionVissionResource extends JsonResource
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

            'services' => $this->services,
            'about'    => $this->about,
            'mission'  => $this->mission,
            'vission'  => $this->vission,
            'breif'    => $this->breif
        ];
    }
}
