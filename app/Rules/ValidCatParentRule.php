<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Cat;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class ValidCatParentRule implements ValidationRule
{
    /**
     * @param string $requiredGender
     * @param string $parentType
     */
    public function __construct(
        protected string $requiredGender,
        protected string $parentType,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null) {
            return;
        }

        if (is_array($value)) {
            foreach ($value as $id) {
                $this->validateParent($id, $fail);
            }
            return;
        }

        $this->validateParent($value, $fail);
    }

    protected function validateParent(mixed $id, Closure $fail): void
    {
        $cat = Cat::query()->find($id);

        if (! $cat instanceof Cat) {
            $fail("Selected $this->parentType does not exist.");
            return;
        }

        if ($cat->gender !== $this->requiredGender) {
            $fail("Selected $this->parentType should be $this->requiredGender gender.");
        }
    }
}
