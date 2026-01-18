<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => ['required','nullable','exists:countries,id'],
        ];
    }


    public function authorize(): bool
    {
        return backpack_auth()->check();
    }
}
