<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\ValidMotherAgeRule;
use App\Rules\ValidCatParentRule;
use Illuminate\Foundation\Http\FormRequest;

final class CreateUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'gender' => [
                'required',
                'in:male,female'
            ],
            'age' => [
                'required',
                'integer',
                'min:0'
            ],
            'mother_id' => [
                'nullable',
                'exists:cats,id',
                new ValidCatParentRule('female', 'mother'),
                new ValidMotherAgeRule()
            ],
            'father_ids' => [
                'nullable',
                'array',
                new ValidCatParentRule('male', 'father or fathers'),
            ],
            'father_ids.*' => [
                'exists:cats,id',
            ],
        ];
    }
}
