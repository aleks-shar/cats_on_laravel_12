<?php

declare(strict_types=1);

namespace App\Services;

use App\Filters\CatsFilter;
use App\Models\Cat;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\Paginator;

final class CatService
{
    /**
     * @param array<string, mixed> $data
     * @return Paginator
     * @throws BindingResolutionException
     */
    public function index(array $data): Paginator
    {
        return Cat::query()->with(['mother', 'fathers'])
            ->filter(app()->make(CatsFilter::class, ['queryParams' => array_filter($data)]))
            ->simplePaginate(20);
    }

    /**
     * @param array<string, mixed> $validated
     * @return Cat
     */
    public function create(array $validated): Cat
    {
        $cat = Cat::query()->create([
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'mother_id' => $validated['mother_id'] ?? null
        ]);

        if (isset($validated['father_ids'])) {
            $cat->fathers()->attach($validated['father_ids']);
        }

        return $cat->load(['mother', 'fathers']);
    }

    /**
     * @param Cat $cat
     * @param array<string, mixed> $validated
     * @return Cat
     */
    public function update(Cat $cat, array $validated): Cat
    {
        $cat->update([
            'name' => $validated['name'] ?? $cat->name,
            'gender' => $validated['gender'] ?? $cat->gender,
            'age' => $validated['age'] ?? $cat->age,
            'mother_id' => $validated['mother_id'] ?? $cat->mother_id
        ]);

        if (isset($validated['father_ids'])) {
            $cat->fathers()->sync($validated['father_ids']);
        }

        return $cat->load(['mother', 'fathers']);
    }

    /**
     * @param Cat $cat
     * @return Cat
     */
    public function show(Cat $cat): Cat
    {
        return $cat->load(['mother', 'fathers', 'kittens', 'fatheredKittens']);
    }

    /**
     * @param Cat $cat
     * @return bool
     */
    public function destroy(Cat $cat): bool
    {
        if (! $cat->delete()) {
            return false;
        }

        return true;
    }

    /**
     * @param int $id
     * @return ?Cat
     */
    public function getCatById(int $id): ?Cat
    {
        return Cat::query()->where(['id' => $id])->first();
    }
}
