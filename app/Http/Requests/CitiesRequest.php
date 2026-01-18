<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitiesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'=>['required','string'],
            'country_id'=>['required','exists:countries,id']
        ];
    }

    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

}
