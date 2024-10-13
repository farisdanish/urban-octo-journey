<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, // Assuming 'id' is the primary key for the states table
            'code' => $this->code, // Assuming 'code' represents the state's code (e.g., MY-01 for Selangor)
            'name' => $this->name, // State name (e.g., Selangor)
        ];
    }
}