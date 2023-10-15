<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransportRequest;
use App\Http\Resources\TransportResource;
use App\Models\Transport;
use App\Services\TransportService;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function __construct(public TransportService $transportService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $manufacturer = $request->get('manufacturer');
        $model = $request->get('model');
        $deleted = (bool) $request->get('deleted');

        $transports = $this->transportService->getTransports($search, $manufacturer, $model, $deleted);

        return TransportResource::collection($transports);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransportRequest $request)
    {
        $transport = $this->transportService->store($request);

        return new TransportResource($transport);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transport $transport)
    {
        $transport->load('Model');

        return new TransportResource($transport);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Transport $transport, TransportRequest $request)
    {
        $transport = $this->transportService->update($transport, $request);

        return new TransportResource($transport);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transport $transport)
    {
        $status = $this->transportService->remove($transport);

        return response()->json(['success' => $status]);
    }
}
