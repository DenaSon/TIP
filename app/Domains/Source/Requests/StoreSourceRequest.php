<?php

namespace Domains\Source\Requests;

use Domains\Source\Models\Source;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                Rule::in(Source::availableTypes()),
            ],

            'config' => [
                'required',
                'array',
            ],

            'config.url' => [
                'required',
                'url',
            ],

            'status' => [
                'required',
                Rule::in(Source::availableStatuses()),
            ],
        ];
    }
}
