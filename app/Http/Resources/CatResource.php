<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Cat
 */
final class CatResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'age' => $this->age,
            'mother' => $this->whenLoaded('mother', function () {
                return new CatMotherResource($this->mother);
            }),
            'fathers' => $this->whenLoaded('fathers', function () {
                return CatFatherResource::collection($this->fathers);
            }),
            'kittens' => $this->whenLoaded('kittens', function () {
                return CatResource::collection($this->kittens);
            }),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
