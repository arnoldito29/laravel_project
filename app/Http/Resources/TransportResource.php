<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'license_plate' => $this->license_plate,
            'fuel_tank_capacity' => $this->fuel_tank_capacity,
            'average_fuel' => $this->average_fuel,
            'estimated_distance' => $this->estimated_distance,
            'model' => new ManufacturerModelResource($this->model),
            'deleted' => $this->deleted_at ? 1 : 0,
        ];
    }
}
