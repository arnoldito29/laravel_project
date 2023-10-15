<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManufacturerRequest;
use App\Http\Resources\ManufacturerResource;
use App\Models\Model;
use App\Services\ModelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManufacturerController extends Controller
{
    public function __construct(public ModelService $modelService)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = $request->get('search');

        return ManufacturerResource::collection($this->modelService->getManufacturers($query));
    }

    /**
     * @param ManufacturerRequest $request
     * @return ManufacturerResource
     */
    public function store(ManufacturerRequest $request): ManufacturerResource
    {
        $manufacturer = $this->modelService->storeManufacturer($request);

        return new ManufacturerResource($manufacturer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Model $manufacturer): ManufacturerResource
    {
        $manufacturer->load('models');

        return new ManufacturerResource($manufacturer);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Model $manufacturer, ManufacturerRequest $request): ManufacturerResource
    {
        $manufacturer = $this->modelService->updateManufacturer($manufacturer, $request);

        return new ManufacturerResource($manufacturer);
    }

    /**
     * @param Model $manufacturer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Model $manufacturer): JsonResponse
    {
        $status = $this->modelService->removeManufacturer($manufacturer);

        return response()->json(['success' => $status]);
    }
}
