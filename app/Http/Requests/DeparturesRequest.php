<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeparturesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'city_id' => ['required','exists:cities,id'],
            'airport_name' => ['required','string'],
            'time' => ['required'],
            'price_diff' => ['required', 'decimal'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
