<?php

namespace App\Services;

use App\Http\Requests\ManufacturerRequest;
use App\Http\Requests\ModelRequest;
use App\ModelFactories\ModelFactory;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Model Service.
 */
class ModelService
{
    /**
     * @param Model $model
     */
    public function __construct(protected Model $model)
    {
    }

    /**
     * @param string|null $query
     *
     * @return Collection
     */
    public function getManufacturers(?string $query): Collection
    {
        $queryBuilder = $this->model::with([
            'models' => function (HasMany $query) {
                $query->orderBy('name');
            }
        ])->whereNull('manufacturer_id');

        if ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}%");
        }

        return $queryBuilder->orderBy('name')->get();
    }

    /**
     * @param ManufacturerRequest $request
     *
     * @return Model
     */
    public function storeManufacturer(ManufacturerRequest $request): Model
    {
        $name = $request->get('name');
        $manufacturer = $this->model::withTrashed()
            ->where('name', $name)
            ->whereNull('manufacturer_id')
            ->first();

        if ($manufacturer) {
            $manufacturer->restore();

            return $manufacturer;
        }

        $manufacturerFactory = new ModelFactory();
        $manufacturer = $manufacturerFactory->createManufacturer($name);

        $manufacturer->save();

        return $manufacturer;
    }

    /**
     * @param Model $manufacturer
     * @param ManufacturerRequest $request
     *
     * @return Model
     */
    public function updateManufacturer(Model $manufacturer, ManufacturerRequest $request): Model
    {
        $name = $request->get('name');
        $manufacturer->update(['name' => $name]);

        return $manufacturer;
    }

    public function removeManufacturer(Model $manufacturer): bool
    {
        $manufacturer->load('models');

        $manufacturer->models->each(function (Model $model) {
            $model->delete();
        });

        return $manufacturer->delete();
    }

    /**
     * @param Model $manufacturer
     * @param string|null $query
     *
     * @return Collection
     */
    public function getModels(Model $manufacturer, ?string $query): Collection
    {
        $queryBuilder = $this->model::with('manufacturer')
            ->where('manufacturer_id', $manufacturer->id);

        if ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}%");
        }

        return $queryBuilder->orderBy('name')->get();
    }

    /**
     * @param string|null $query
     *
     * @return Collection
     */
    public function getAllModels(?string $query): Collection
    {
        $queryBuilder = $this->model::with('manufacturer')->whereNotNull('manufacturer_id');

        if ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}%");
        }

        return $queryBuilder->orderBy('name')->get();
    }

    /**
     * @param Model $manufacturer
     * @param Model $model
     *
     * @return Model
     */
    public function getModel(Model $manufacturer, Model $model): Model
    {
        return $manufacturer->models()->where('id', $model->id)->firstOrFail();
    }

    /**
     * @param Model $manufacturer
     * @param ModelRequest $request
     *
     * @return Model
     */
    public function storeModel(Model $manufacturer, ModelRequest $request): Model
    {
        $name = $request->get('name');
        $model = $this->model::withTrashed()
            ->where('name', $name)
            ->where('manufacturer_id', $manufacturer->id)
            ->first();

        if ($model) {
            $model->restore();

            return $model;
        }

        $modelFactory = new ModelFactory();
        $model = $modelFactory->createModel($name, $manufacturer);

        $model->save();

        return $model;
    }

    /**
     * @param Model $manufacturer
     * @param Model $model
     * @param ModelRequest $request
     *
     * @return Model
     */
    public function updateModel(Model $manufacturer, Model $model, ModelRequest $request): Model
    {
        $name = $request->get('name');
        $model = $this->getModel($manufacturer, $model);
        $model->update(['name' => $name]);

        return $model;
    }

    /**
     * @param Model $model
     *
     * @return bool
     */
    public function removeModel(Model $model): bool
    {
        return $model->delete();
    }
}
