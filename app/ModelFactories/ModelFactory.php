<?php

namespace App\ModelFactories;

use App\Models\Model;
use App\Models\Transport;

class ModelFactory
{
    /**
     * @param string $name
     * @param Model|null $manufacturer
     *
     * @return Model
     */
    public function create(string $name, ?Model $manufacturer = null): Model
    {
        $model = new Model();
        $model->name = $name;

        if ($manufacturer) {
            $model->manufacturer_id = $manufacturer->id;
        }

        return $model;
    }

    /**
     * @param string $name
     *
     * @return Model
     */
    public function createManufacturer(string $name): Model
    {
        return $this->create($name);
    }

    /**
     * @param string $name
     * @param Model $manufacturer
     *
     * @return Model
     */
    public function createModel(string $name, Model $manufacturer): Model
    {
        return $this->create($name, $manufacturer);
    }
}
