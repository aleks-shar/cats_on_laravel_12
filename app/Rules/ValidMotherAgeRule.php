<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Cat;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

final class ValidMotherAgeRule implements DataAwareRule, ValidationRule
{
    /**
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cat = Cat::query()->find($value);

        if (! $cat instanceof Cat) {
            $fail("Selected mother does not exist.");
            return;
        }

        if ($cat->age < $this->data['age']) {
            $fail("The mother must be older than the kitten.");
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
