<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ManufacturerRequest;
use App\Http\Requests\ModelRequest;
use App\Http\Requests\TransportRequest;
use App\ModelFactories\ModelFactory;
use App\ModelFactories\TransportFactory;
use App\Models\Model;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Transport service.
 */
class TransportService
{
    /**
     * @param Transport $transport
     * @param Model $model
     */
    public function __construct(protected Transport $transport, protected Model $model)
    {
    }

    /**
     * @param string|null $search
     * @param string|null $manufacturer
     * @param string|null $model
     * @param bool|null $deleted
     *
     * @return Collection
     */
    public function getTransports(?string $search, ?string $manufacturer, ?string $model, ?bool $deleted): Collection
    {
        if ($deleted) {
            $queryBuilder = $this->transport::withTrashed();
        } else {
            $queryBuilder = $this->transport;
        }

        $queryBuilder = $queryBuilder->with(['model', 'model.manufacturer']);

        if ($model) {
            $queryBuilder = $queryBuilder->whereHas('model', function ($sub) use ($model) {
                if (!empty($model)) {
                    $sub->where('id', $model);
                }
            });
        }

        if ($manufacturer) {
            $queryBuilder = $queryBuilder->whereHas('model', function ($sub) use ($manufacturer) {
                if (!empty($manufacturer)) {
                    $sub->whereHas('manufacturer', function ($subSub) use ($manufacturer) {
                        if (!empty($manufacturer)) {
                            $subSub->where('id', $manufacturer);
                        }
                    });
                }
            });
        }

        if ($search) {
            $queryBuilder->where('license_plate', 'LIKE', "%{$search}%");
        }

        return $queryBuilder->orderBy('license_plate')->get();
    }

    /**
     * @param float $tankCapacity
     * @param float $average
     *
     * @return float
     */
    private function calcualteDiscance(float $tankCapacity, float $average): float
    {
        return $tankCapacity / $average * 100;
    }

    /**
     * @param TransportRequest $request
     *
     * @return Transport
     */
    public function store(TransportRequest $request): Transport
    {
        $licensePlate = $request->get('license_plate');
        $modelId = $request->get('model_id');
        $tankCapacity = (float)$request->get('fuel_tank_capacity');
        $average = (float)$request->get('average_fuel');
        $distance = $this->calcualteDiscance($tankCapacity, $average);

        $oldTransport = $this->transport->withTrashed()
            ->where('license_plate', $licensePlate)
            ->where('model_id', $modelId)
            ->first();

        if ($oldTransport) {
            $oldTransport->restore();

            $oldTransport->update([
                'fuel_tank_capacity' => $tankCapacity,
                'average_fuel' => $average,
                'estimated_distance' => $distance,
            ]);

            return $oldTransport;
        }

        $model = $this->model->find($modelId);

        $transportFactory = new TransportFactory();
        $transport = $transportFactory->create($licensePlate, $tankCapacity, $average, $distance, $model);

        $transport->save();

        return $transport;
    }

    /**
     * @param Transport $transport
     * @param TransportRequest $request
     *
     * @return Transport
     */
    public function update(Transport $transport, TransportRequest $request): Transport
    {
        $licensePlate = $request->get('license_plate');
        $modelId = $request->get('model_id');
        $tankCapacity = (float)$request->get('fuel_tank_capacity');
        $average = (float)$request->get('average_fuel');
        $distance = $this->calcualteDiscance($tankCapacity, $average);
        $transport->update([
            'license_plate' => $licensePlate,
            'model_id' => $modelId,
            'fuel_tank_capacity' => $tankCapacity,
            'average_fuel' => $average,
            'estimated_distance' => $distance,
        ]);

        return $transport;
    }

    /**
     * @param Transport $transport
     *
     * @return bool
     */
    public function remove(Transport $transport): bool
    {
        return $transport->delete();
    }
}
