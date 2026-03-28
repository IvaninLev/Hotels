<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'main_text' => ['required', 'string'],
            'avatar' => ['required', 'array'],
            'was_in_hotel' => ['required', 'string'],
            'person_from' => ['required', 'string'],
            'flight_to' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'flight_date' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
