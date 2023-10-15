<?php

namespace App\ModelFactories;

use App\Models\Model;
use App\Models\Transport;

class ModelFactory
{
    public function create(string $name, ?Model $manufacturer = null): Model
    {
        $model = new Model();
        $model->name = $name;

        if ($manufacturer) {
            $model->manufacturer_id = $manufacturer->id;
        }

        return $model;
    }

    public function createManufacturer(string $name): Model
    {
        return $this->create($name);
    }

    public function createModel(string $name, Model $manufacturer): Model
    {
        return $this->create($name, $manufacturer);
    }
}
