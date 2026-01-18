<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'=>['required','string'],
            'city'=>['required','exists:cities,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
