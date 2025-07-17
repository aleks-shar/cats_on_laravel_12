<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Cat
 */
final class CatMotherResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'link' => route('cats.show', $this->id),
        ];
    }
}
