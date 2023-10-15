<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModelRequest;
use App\Http\Resources\ManufacturerModelResource;
use App\Http\Resources\ModelResource;
use App\Models\Model;
use App\Services\ModelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ModelController extends Controller
{
    public function __construct(public ModelService $modelService)
    {
    }

    /**
     * @param Model $manufacturer
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Model $manufacturer, Request $request): AnonymousResourceCollection
    {
        $query = $request->get('search');

        return ModelResource::collection($this->modelService->getModels($manufacturer, $query));
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function all(Request $request): AnonymousResourceCollection
    {
        $query = $request->get('search');

        return ManufacturerModelResource::collection($this->modelService->getAllModels($query));
    }

    /**
     * @param Model $manufacturer
     * @param ModelRequest $request
     * @return ModelResource
     */
    public function store(Model $manufacturer, ModelRequest $request): ModelResource
    {
        $model = $this->modelService->storeModel($manufacturer, $request);

        return new ModelResource($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(Model $manufacturer, Model $model): ModelResource
    {
        $modelElement = $this->modelService->getModel($manufacturer, $model);

        return new ModelResource($modelElement);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Model $manufacturer, Model $model, ModelRequest $request): ModelResource
    {
        $modelElement = $this->modelService->updateModel($manufacturer, $model, $request);

        return new ModelResource($modelElement);
    }

    /**
     * @param Model $manufacturer
     * @param Model $model
     * @return JsonResponse
     */
    public function destroy(Model $manufacturer, Model $model): JsonResponse
    {
        $modelElement = $this->modelService->getModel($manufacturer, $model);
        $status = $this->modelService->removeModel($modelElement);

        return response()->json(['success' => $status]);
    }
}
