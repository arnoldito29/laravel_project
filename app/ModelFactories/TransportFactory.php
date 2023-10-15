<?php

namespace App\ModelFactories;

use App\Models\Model;
use App\Models\Transport;

class TransportFactory
{
    /**
     * @param string $licensePlate
     * @param float $tankCapacity
     * @param float $average
     * @param float $distance
     * @param Model|null $model
     *
     * @return Transport
     */
    public function create(
        string $licensePlate,
        float $tankCapacity,
        float $average,
        float $distance,
        ?Model $model
    ): Transport {
        $transport = new Transport();
        $transport->license_plate = $licensePlate;
        $transport->fuel_tank_capacity = $tankCapacity;
        $transport->average_fuel = $average;
        $transport->estimated_distance = $distance;
        $transport->model_id = $model->id;

        return $transport;
    }
}
