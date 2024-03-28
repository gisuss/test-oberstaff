<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'dni' => $this->dni,
            'email' => $this->email,
            'address' => $this->address,
            'date_reg' => $this->date_reg,
            'commune' => $this->commune->description,
            'region' => $this->region->description,
        ];
    }
}
