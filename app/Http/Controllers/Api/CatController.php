<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Resources\CatCollection;
use App\Http\Resources\CatResource;
use App\Models\Cat;
use App\Services\CatService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class CatController extends Controller
{
    public function __construct(
        private readonly CatService $service
    ) {
    }

    /**
     * @param IndexRequest $request
     * @return ResourceCollection
     * @throws BindingResolutionException
     */
    public function index(IndexRequest $request): ResourceCollection
    {
        return new CatCollection($this->service->index($request->validated()));
    }

    /**
     * @param CreateUpdateRequest $request
     * @return CatResource
     */
    public function store(CreateUpdateRequest $request): CatResource
    {
        return new CatResource($this->service->create($request->validated()));
    }

    /**
     * @param Cat $cat
     * @return CatResource
     */
    public function show(Cat $cat): CatResource
    {
        return new CatResource($this->service->show($cat));
    }

    /**
     * @param CreateUpdateRequest $request
     * @param Cat $cat
     * @return CatResource
     */
    public function update(CreateUpdateRequest $request, Cat $cat): CatResource
    {
        return new CatResource($this->service->update($cat, $request->validated()));
    }

    /**
     * @param Cat $cat
     * @return JsonResponse
     */
    public function destroy(Cat $cat): JsonResponse
    {
        if (! $this->service->destroy($cat)) {
            return response()->json(null, 404);
        }

        return response()->json(null, 204);
    }
}
