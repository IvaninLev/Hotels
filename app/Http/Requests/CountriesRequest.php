<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountriesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'iso_code' => ['required', 'string', 'min:3', 'max:3']
        ];
    }

    public function authorize(): bool
    {
        return backpack_auth()->check();
    }
}
